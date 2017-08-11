<div id="{{ $id }}" style="width: 100%;"></div>
@php
Admin::script(<<<SCRIPT
    new JSONEditor(
        document.getElementById('{$id}'),
        {
            mode: 'view'
        },
        {$json}
    );
SCRIPT
);
@endphp