<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

    <label for="{{$id}}" class="col-sm-{{$width['label']}} control-label">{{$label}}</label>

    <div class="col-sm-{{$width['field']}}">

        @include('admin::form.error')
        <div id="{{ $name }}" style="width: 100%; height: 200px;"></div>
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @include('admin::form.help-block')
    </div>
</div>