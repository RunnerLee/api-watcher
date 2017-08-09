<?php

namespace App\Console\Commands;

use App\Models\Api;
use App\Models\ApiGroup;
use App\Models\Faker;
use App\Models\Mission;
use App\Models\Result;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use function GuzzleHttp\Promise\unwrap;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;
use Validator;

class Tester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watcher:execute {api-group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'execute watcher';

    protected $results = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apiGroup = ApiGroup::with('apis.fakers')->findOrFail($this->argument('api-group'));

        if (!$apiGroup->apis) {
            return 0;
        }

        $client = new Client();

        $promises = [];

        $mission = Mission::create([
            'api_group_id' => $apiGroup->id,
            'start_time' => microtime(true),
            'finish_time' => 0,
        ]);

        $beginRequestTime = 0;

        foreach ($apiGroup->apis as $api) {

            foreach ($api->fakers as $faker) {
                $promises[] = $client
                    ->requestAsync(
                        $api->method,
                        $this->buildRequestUrl($api, $faker),
                        $this->buildRequestOption($api, $faker)
                    )
                    ->then(
                        function (ResponseInterface $response) use ($api, $faker, $mission, &$beginRequestTime) {
                            $this->parseResponseAndSaveResult($response, $api, $faker, $mission, $beginRequestTime);
                        },
                        function (RequestException $exception) use ($api, $faker, $mission, &$beginRequestTime) {
                            $this->parseExceptionAndSaveResult($exception, $api, $faker, $mission, $beginRequestTime);
                        }
                    );
            }
        }

        $beginRequestTime = microtime(true);

        unwrap($promises);

        $mission->finish_time = microtime(true);
        $mission->result_count = count($this->results);

        $unsuccessfulCount = 0;

        foreach ($this->results as $result) {
            if ('no' === $result->is_successful) {
                ++$unsuccessfulCount;
            }
        }

        $mission->unsuccessful_result_count = $unsuccessfulCount;

        if (!$unsuccessfulCount) {
            $mission->is_solved = 'yes';
        } else {
            $this->sendMessage($mission);
        }

        $mission->save();
    }

    protected function buildRequestOption(Api $api, Faker $faker)
    {
        $option = [
            'query' => json_decode($faker->queries, true),
            'headers' => array_merge(
                json_decode($api->headers, true),
                json_decode($faker->headers, true)
            ),
            'timeout' => $api->timeout,
            'connect_timeout' => $api->timeout,
        ];
        if ('GET' !== $api->method) {
            $option['form_params'] = json_decode($faker->requests);
        }
        $option = array_merge($option, json_decode($api->options, true));
        $option['http_errors'] = false;

        return $option;
    }

    protected function buildRequestUrl(Api $api, Faker $faker)
    {
        $variables = json_decode($faker->variables);
        if (!$variables) {
            return $api->url;
        }
        $search = $replace = [];
        foreach ($variables as $key => $value) {
            $search[] = "{{$key}}";
            $replace[] = $value;
        }
        return str_replace($search, $replace, $api->url);
    }

    protected function parseResponseAndSaveResult(ResponseInterface $response, Api $api, Faker $faker, Mission $mission, $beginRequestTime)
    {
        $finishRequestTime = microtime(true);

        /**
         * 先判断状态码是否符合预期, 如果不符合预期, 则不进行内容格式校验
         */
        $isSuccessful = $response->getStatusCode() == $api->except_status;
        $isSuccessful && $isSuccessful = $this->validate($response, $api);

        $this->results[] = Result::create([
            'api_id' => $api->id,
            'faker_id' => $faker->id,
            'mission_id' => $mission->id,
            'is_successful' => $isSuccessful ? 'yes' : 'no',
            'is_timeout' => 'no',
            'time_cost' => (int)round(($finishRequestTime - $beginRequestTime) * 1000),
            'status_code' => $response->getStatusCode(),
            'response_size' => $response->getBody()->getSize(),
            'response_headers' => json_encode($response->getHeaders()),
            'response_content' => (string)$response->getBody(),
        ]);
    }

    protected function parseExceptionAndSaveResult(RequestException $e, Api $api, Faker $faker, Mission $mission, $beginRequestTime)
    {
        $data = [
            'api_id' => $api->id,
            'faker_id' => $faker->id,
            'mission_id' => $mission->id,
            'is_successful' => 'no',
            'is_timeout' => 'no',
            'time_cost' => 0,
            'status_code' => 0,
            'response_size' => 0,
            'response_headers' => '{}',
            'response_content' => '',
            'error_message' => $e->getMessage(),
        ];

        if (false !== strpos($e->getMessage(), 'timed out')) {
            $data['time_cost'] = $api->timeout;
            $data['is_timeout'] = 'yes';
        } else if ($response = $e->getResponse()) {
            $data['status_code'] = $response->getStatusCode();
            $data['response_size'] = $response->getBody()->getSize();
            $data['response_headers'] = json_encode($response->getHeaders());
            $data['response_content'] = (string)$response->getBody();
        }

        $this->results[] = Result::create($data);
    }

    protected function validate(ResponseInterface $response, Api $api)
    {
        /**
         * 先判断是不是数组
         */
        if (!is_array($data = json_decode((string)$response->getBody(), true))) {
            return false;
        }
        /**
         * 再判断有没有规则
         */
        if (!$rules = json_decode($api->rules, true)) {
            return true;
        }

        return Validator::make($data, $rules)->passes();
    }

    protected function sendMessage(Mission $mission)
    {
        $client = new Client();

        $response = $client->request('POST', 'http://127.0.0.1:9001', [
            'body' => json_encode([
                'action' => 'search',
                'params' => [
                    'type' => 'groups',
                    'method' => 'getObject',
                    'filter' => ['hello', 'NickName', false, true],
                ],
            ]),
        ]);

        $content = json_decode($response->getBody(), true);

        $username = $content['result']['groups']['UserName'];

        $client->request('POST', 'http://127.0.0.1:9001', [
            'body' => json_encode([
                'action' => 'send',
                'params' => [
                    'type' => 'text',
                    'username' => $username,
                    'content' => <<<MESSAGE
  FBI Warning
接口测试 任务告警

任务编号: {$mission->id}
测试分组: {$mission->apiGroup->name}
开始时间: {$mission->start_time}
结束时间: {$mission->finish_time}
结果总数: {$mission->result_count}
失败总数: {$mission->unsuccessful_result_count}

回复 "查看任务:{id}" 或 @ 我 开始接手任务.
MESSAGE
                ],
            ]),
        ]);
    }
}
