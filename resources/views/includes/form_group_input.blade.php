@php ($id = htmlId())
<div class="form-group">
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
        @include('includes.input', [
            'id' => $id,
            'type' => $type ?? null,
            'name' => $name ?? null,
            'dataValidation' => $dataValidation ?? null,
            'dataValidationConfirm' => $dataValidationConfirm ?? null,
            'dataValidationLength' => $dataValidationLength ?? null,
            'value' => $value ?? null,
            'disabled' => $disabled ?? null,
        ])
    </div>
</div>
