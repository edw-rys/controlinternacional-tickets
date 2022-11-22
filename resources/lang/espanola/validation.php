<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute debe ser aceptado.',
    'active_url' => ':attribute no es una URL válida.',
    'after' => ':attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => ':attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => ':attribute solo debe contener letras.',
    'alpha_dash' => ':attribute solo debe contener letras, números, guiones y guiones bajos.',
    'alpha_num' => ':attributesolo debe contener letras y números.',
    'array' => ':attribute debe ser una matriz.',
    'before' => ':attribute debe ser una fecha anterior :date.',
    'before_or_equal' => ':attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => ':attribute debe estar entre :min y :max.',
        'file' => ':attribute debe estar entre :min y :max kilobytes.',
        'string' => ':attribute debe estar entre :min y :max caracteres.',
        'array' => ':attribute debe tener entre :min y :max items.',
    ],
    'boolean' => ':attribute el campo debe ser verdadero o falso.',
    'confirmed' => ':attribute la confirmación no coincide.',
    'date' => ':attribute no es una fecha válida.',
    'date_equals' => ':attribute debe ser una fecha igual a :date.',
    'date_format' => ':attribute no coincide con el formato :format.',
    'different' => ':attribute y :other debe ser diferente.',
    'digits' => ':attribute debe ser :digits dígitos.',
    'digits_between' => ':attribute debe estar entre :min y :max dígitos.',
    'dimensions' => ':attribute tiene dimensiones de imagen no válidas.',
    'distinct' => ':attribute el campo tiene un valor duplicado.',
    'email' => ':attribute Debe ser una dirección de correo electrónico válida.',
    'ends_with' => ':attribute debe terminar con uno de los siguientes: :values.',
    'exists' => ':attribute seleccionado no es válido.',
    'file' => ':attribute debe ser un archivo.',
    'filled' => ':attribute el campo debe tener un valor.',
    'gt' => [
        'numeric' => ':attribute debe ser mayor que :value.',
        'file' => ':attribute debe ser mayor que :value kilobytes.',
        'string' => ':attribute debe ser mayor que :value caracteres.',
        'array' => ':attribute debe tener más de :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute debe ser mayor o igual :value.',
        'file' => ':attribute debe ser mayor o igual :value kilobytes.',
        'string' => ':attribute debe ser mayor o igual :value characters.',
        'array' => ':attribute debe tener :value items o más.',
    ],
    'image' => ':attribute debe ser una image.',
    'in' => 'Selección :attribute es inválida.',
    'in_array' => ':attribute fieldno existe en :other.',
    'integer' => ':attribute debe ser un entero.',
    'ip' => ':attribute debe ser una dirección IP válida.',
    'ipv4' => ':attribute debe ser una dirección IPv4 válida.',
    'ipv6' => ':attribute debe ser una dirección IPv6 válida.',
    'json' => ':attribute debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => ':attribute debe ser menor que :value.',
        'file' => ':attribute debe ser menor que :value kilobytes.',
        'string' => ':attribute debe ser menor que :value carateres.',
        'array' => ':attribute debe tener menos de :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute es requerido.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => ':attribute debe comenzar con uno de los siguientes: :values.',
    'string' => ':attribute debe ser una cadena.',
    'timezone' => ':attribute debe ser una zona válida.',
    'unique' => ':attribute ya se ha tomado.',
    'uploaded' => ':attribute no se pudo cargar.',
    'url' => ':attribute el formato no es válido.',
    'uuid' => ':attribute debe ser un UUID válido.',

    'captcha' => 'Ingrese un captcha válido',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'password'  => 'Contraseña',
        'message'   => 'Mensaje',
        'subject'   => 'Asunto',
        'category'   => 'Categoría',
    ],

];
