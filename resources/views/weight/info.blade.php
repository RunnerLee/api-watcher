<dl class="dl-horizontal">
    <dt>API</dt>
    <dd><a href="{{ route('apis.show', $result->api_id) }}">{{ $result->api->name }}</a></dd>
    <dt>Faker</dt>
    <dd><a href="{{ route('fakers.show', $result->faker_id) }}">{{ $result->faker_id }}</a></dd>
    <dt>Url</dt>
    <dd>{{ $result->api->url }}</dd>
    <dt>Except Status</dt>
    <dd>{{ $result->api->except_status }}</dd>
    <dt>Method</dt>
    <dd>{{ $result->api->method }}</dd>
    <dt>Timeout</dt>
    <dd>{{ $result->api->timeout }}</dd>
    <dt>Successful</dt>
    <dd>
        @if ('yes' === $result->is_successful)
            <i class="fa fa-check" style="color: green"></i>
        @else
            <i class="fa fa-close" style="color: red"></i>
        @endif
    </dd>
    <dt>Is Timeout</dt>
    <dd>{{ $result->is_timeout }}</dd>
    <dt>Time Cost</dt>
    <dd>{{ $result->time_cost }}</dd>
    <dt>Response Status</dt>
    <dd>{{ $result->status_code }}</dd>
    <dt>Response Size</dt>
    <dd>{{ $result->response_size }}</dd>
</dl>