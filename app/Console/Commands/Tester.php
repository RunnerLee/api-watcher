<?php

namespace App\Console\Commands;

use App\Models\Api;
use App\Models\ApiGroup;
use App\Models\Faker;
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

        $apiGroup->apis->map(function (Api $api) use (&$promises, $client) {
            $api->fakers->map(function (Faker $faker) use ($api, &$promises, $client) {
                $promises[] = $client
                    ->requestAsync(
                        $api->method,
                        $this->buildRequestUrl($api, $faker),
                        $this->buildRequestOption($api, $faker)
                    )
                    ->then(
                        function (ResponseInterface $response) use ($api, $faker) {
                            $this->parseAndSaveResult($response, $api, $faker);
                        },
                        function (RequestException $exception) use ($api, $faker) {

                        }
                    );
            });
        });

        unwrap($promises);
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

    protected function parseAndSaveResult(ResponseInterface $response, Api $api, Faker $faker)
    {
        $isSuccessful = $response->getStatusCode() == $api->except_status;
        $isSuccessful && $isSuccessful = $this->validate($response, $api);

        $result = Result::create([
            'api_id' => $api->id,
            'faker_id' => $faker->id,
            'is_successful' => $isSuccessful ? 'yes' : 'no',
            'is_timeout' => 'no',
            'time_cost' => 0,
            'status_code' => $response->getStatusCode(),
            'response_size' => $response->getBody()->getSize(),
            'response_headers' => json_encode($response->getHeaders()),
            'response_content' => (string)$response->getBody(),
        ]);
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
}
