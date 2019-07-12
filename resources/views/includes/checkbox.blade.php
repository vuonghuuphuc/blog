@php ($id = htmlId())
<div class="custom-control custom-checkbox">
    <input  
    @isset($checked)
    {{ $checked ? 'checked="checked"': '' }}
    @endif
    type="checkbox" class="custom-control-input" id="{{ $id }}" name="{{ $name ?? '' }}">
    <label class="custom-control-label" for="{{ $id }}">{{ $label ?? '' }}</label>
</div>