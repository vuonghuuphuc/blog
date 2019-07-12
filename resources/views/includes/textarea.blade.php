<textarea 
    @isset($id)
    id="{{ $id }}"
    @endif
    @isset($name)
    name="{{ $name }}"
    @endif
    @isset($dataValidation)
    data-validation="{{ $dataValidation }}"
    @endif
    @isset($disabled)
    {{ $disabled ? 'disabled="disabled"': '' }}
    @endif
    @isset($readonly)
    {{ $readonly ? 'readonly="readonly"': '' }}
    @endif
    rows="{{ $rows ?? 3 }}"
    class="{{ $class ?? 'form-control' }}">{{ $value ?? '' }}</textarea>