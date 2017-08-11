<dl class="dl-horizontal">
    @foreach($headers as $name => $values)
        @foreach($values as $value)
            <dt>{!! $name !!}</dt>
            <dd>{!! $value !!}</dd>
        @endforeach
    @endforeach
</dl>