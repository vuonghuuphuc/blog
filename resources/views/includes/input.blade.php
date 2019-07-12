<input 
    @isset($id)
    id="{{ $id }}"
    @endif
    @isset($name)
    name="{{ $name }}"
    @endif
    @isset($dataValidation)
    data-validation="{{ $dataValidation }}"
    @endif
    @isset($dataValidationConfirm)
    data-validation-confirm="{{ $dataValidationConfirm }}"
    @endif
    @isset($dataValidationLength)
    data-validation-length="{{ $dataValidationLength }}"
    @endif
    @isset($disabled)
    {{ $disabled ? 'disabled="disabled"': '' }}
    @endif
    @isset($readonly)
    {{ $readonly ? 'readonly="readonly"': '' }}
    @endif
    value="{{ $value ?? '' }}"
    type="{{ $type ?? 'text' }}"
    class="{{ $class ?? 'form-control' }}">