@php ($id = htmlId())
<div class="{{ $formGroupClass ?? 'form-group' }}">
    @if (isset($label))
    <label for="{{ $id }}">{{ $label }}</label>
    @endif
    <div class="input-group">
        @isset($icon)
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="{{ $icon }}"></i>
            </span>
        </div>
        @endif
        @include('includes.textarea', [
            'id' => $id,
            'name' => $name ?? null,
            'dataValidation' => $dataValidation ?? null,
            'value' => $value ?? null,
            'disabled' => $disabled ?? null,
            'rows' => $rows ?? null,
        ])
    </div>
</div>
