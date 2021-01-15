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

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => ':attribute hanya boleh diisi URL yang valid.',
    'after'                => ':attribute hanya boleh diisi tanggal setelah :date.',
    'after_or_equal'       => ':attribute hanya boleh diisi tanggal hari ini atau setelah :date.',
    'alpha'                => ':attribute hanya boleh diisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh diisi huruf, angka, strip dan garis bawah.',
    'alpha_num'            => ':attribute hanya boleh diisi huruf dan angka.',
    'array'                => ':attribute hanya boleh diisi array.',
    'before'               => ':attribute hanya boleh diisi tanggal sebelum :date.',
    'before_or_equal'      => ':attribute hanya boleh diisi tanggal hari ini atau sebelum :date.',
    'between'              => [
        'numeric' => ':attribute hanya boleh diisi bilangan antara :min hingga :max.',
        'file'    => ':attribute hanya boleh berukuran antara :min hingga :max kB.',
        'string'  => ':attribute hanya boleh diisi :min hingga :max karakter.',
        'array'   => ':attribute hanya boleh diisi :min hingga :max item.',
    ],
    'boolean'              => ':attribute hanya boleh diisi benar atau salah.',
    'confirmed'            => ':attribute tidak cocok.',
    'date'                 => ':attribute hanya boleh diisi tanggal.',
    'date_format'          => ':attribute hanya boleh diisi tanggal dengan format :format.',
    'different'            => ':attribute dan :other harus diisi berbeda.',
    'digits'               => ':attribute hanya boleh diisi :digits digit.',
    'digits_between'       => ':attribute hanya boleh diisi antara :min hingga :max digit.',
    'dimensions'           => 'Dimensi gambar :attribute tidak valid.',
    'distinct'             => ':attribute tidak boleh berisi item yang sama.',
    'email'                => ':attribute hanya boleh diisi email yang valid.',
    'exists'               => ':attribute tidak ditemukan atau tidak dikenal.',
    'file'                 => ':attribute harus berupa file.',
    'filled'               => ':attribute harus diisi.',
    'gt'                   => [
        'numeric' => ':attribute harus lebih dari :value.',
        'file'    => ':attribute harus berukuran lebih dari :value kB.',
        'string'  => ':attribute harus diisi lebih dari :value karakter.',
        'array'   => ':attribute harus diisi lebih dari :value item.',
    ],
    'gte'                  => [
        'numeric' => ':attribute harus sama atau lebih dari :value.',
        'file'    => ':attribute harus berukuran sama atau lebih dari :value kB.',
        'string'  => ':attribute harus diisi paling sedikit :value karakter.',
        'array'   => ':attribute harus diisi paling sedikit :value item.',
    ],
    'image'                => ':attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => ':attribute harus dipilih dari :other.',
    'integer'              => ':attribute harus berupa bilangan bulat.',
    'ip'                   => ':attribute hanya boleh diisi IP address yang valid.',
    'ipv4'                 => ':attribute hanya boleh diisi IPv4 address yang valid.',
    'ipv6'                 => ':attribute hanya boleh diisi IPv6 address yang valid.',
    'json'                 => ':attribute harus berupa JSON.',
    'lt'                   => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file'    => ':attribute harus berukuran kurang dari :value kB.',
        'string'  => ':attribute harus diisi kurang dari :value karakter.',
        'array'   => ':attribute harus diisi kurang dari :value item.',
    ],
    'lte'                  => [
        'numeric' => ':attribute harus sama atau kurang dari :value.',
        'file'    => ':attribute harus berukuran sama atau kurang dari :value kB.',
        'string'  => ':attribute harus diisi paling banyak :value karakter.',
        'array'   => ':attribute harus diisi paling banyak :value item.',
    ],
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => ':attribute tidak boleh berukuran lebih dari :max kB.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => ':attribute harus diisi paling banyak :max item.',
    ],
    'mimes'                => ':attribute harus berupa file bertipe: :values.',
    'mimetypes'            => ':attribute harus berupa file bertipe: :values.',
    'min'                  => [
        'numeric' => ':attribute tidak boleh kurang dari :min.',
        'file'    => ':attribute tidak boleh berukuran kurang dari :min kB.',
        'string'  => ':attribute tidak boleh kurang dari :min karakter.',
        'array'   => ':attribute harus diisi paling sedikit :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => ':attribute harus diisi dengan format yang valid.',
    'numeric'              => ':attribute harus diisi angka.',
    'present'              => ':attribute harus diisi.',
    'regex'                => ':attribute harus diisi dengan format yang valid.',
    'required'             => ':attribute harus diisi.',
    'required_if'          => ':attribute harus diisi apabila :other diisi :value.',
    'required_unless'      => ':attribute harus diisi kecuali :other diisi :values.',
    'required_with'        => ':attribute harus diisi kalau :values diisi.',
    'required_with_all'    => ':attribute harus diisi kalau :values diisi.',
    'required_without'     => ':attribute harus diisi kalau :values tidak diisi.',
    'required_without_all' => ':attribute harus diisi kalau :values tidak diisi.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus berukuran :size kB.',
        'string'  => ':attribute harus :size karakter.',
        'array'   => ':attribute harus diisi :size item.',
    ],
    'string'               => ':attribute harus berupa kalimat.',
    'timezone'             => ':attribute harus diisi zona waktu yang valid.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => ':attribute gagal diupload.',
    'url'                  => ':attribute harus diisi dengan format URL.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
