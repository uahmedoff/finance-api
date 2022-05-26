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

    'accepted' => ':attribute qabul qilinishi kerak.',
    'active_url' => ':attribute haqiqiy URL manzil emas.',
    'after' => ':attribute :date dan keyingi sana bo`lishi kerak.',
    'after_or_equal' => ':attribute :date sanasidan keyingi yoki unga teng bo`lishi kerak.',
    'alpha' => ':attribute faqat harflardan iborat bo`lishi mumkin.',
    'alpha_dash' => ':attribute da faqat harflar, raqamlar, tire va pastki chiziq bo`lishi mumkin.',
    'alpha_num' => ':attribute faqat harflar va raqamlardan iborat bo`lishi mumkin.',
    'array' => ':attribute massiv bo`lishi kerak.',
    'before' => ':attribute :date sanasidan oldingi sana bo`lishi kerak.',
    'before_or_equal' => ':attribute :date dan oldin yoki unga teng bo`lishi kerak.',
    'between' => [
        'numeric' => ':attribute :min va :max orasida bo`lishi kerak.',
        'file' => ':attribute :min va :max kilobaytlar orasida bo`lishi kerak.',
        'string' => ':attribute :min va :max belgilar orasida bo`lishi kerak.',
        'array' => ':attribute :min va :max orasida bo`lishi kerak.',
    ],
    'boolean' => ':attribute maydoni true yoki false bo`lishi kerak.',
    'confirmed' => ':attribute tasdiqlash mos emas.',
    'date' => ':attribute haqiqiy sana emas.',
    'date_equals' => ':attribute :date ga teng sana bo`lishi kerak.',
    'date_format' => ':attribute :format formatiga mos kelmaydi.',
    'different' => ':attribute va :other har xil bo`lishi kerak.',
    'digits' => ':attribute :digits ta raqam bo`lishi kerak.',
    'digits_between' => ':attribute :min va :max raqamlari orasida bo`lishi kerak.',
    'dimensions' => ':attribute da rasm o`lchamlari noto`g`ri.',
    'distinct' => ':attribute maydoni dublikat qiymatga ega.',
    'email' => ':attribute haqiqiy elektron pochta manzili bo`lishi kerak.',
    'ends_with' => ':attribute quyidagilardan biri bilan tugashi kerak: :values.',
    'exists' => 'Tanlangan :attribute notog`ri.',
    'file' => ':attribute fayl bo`lishi kerak.',
    'filled' => ':attribute maydonida qiymat bo`lishi kerak.',
    'gt' => [
        'numeric' => ':attribute :value dan katta bo`lishi kerak.',
        'file' => ':attribute :value kilobaytdan katta bo`lishi kerak.',
        'string' => ':attribute :value belgilaridan katta bo`lishi kerak.',
        'array' => ':attribute da :value dan ortiq element bo`lishi kerak.',
    ],
    'gte' => [
        'numeric' => ':attribute :value dan katta yoki teng bo`lishi kerak.',
        'file' => ':attribute :value kilobaytdan katta yoki teng bo`lishi kerak.',
        'string' => ':attribute :value belgilaridan katta yoki teng bo`lishi kerak.',
        'array' => ':attribute da :value elementi yoki undan ko`p bo`lishi kerak.',
    ],
    'image' => ':attribute rasm bo`lishi kerak.',
    'in' => 'Tanlangan :attribute noto`g`ri.',
    'in_array' => ':attribute maydoni :other ichida mavjud emas.',
    'integer' => ':attribute butun son bo`lishi kerak.',
    'ip' => ':attribute to`g`ri IP manzil bo`lishi kerak.',
    'ipv4' => ':attribute haqiqiy IPv4 manzili bo`lishi kerak.',
    'ipv6' => ':attribute haqiqiy IPv6 manzili bo`lishi kerak.',
    'json' => ':attribute to`g`ri JSON satr bo`lishi kerak.',
    'lt' => [
        'numeric' => ':attribute :value dan kichik bo`lishi kerak.',
        'file' => ':attribute :value kilobaytdan kichik bo`lishi kerak.',
        'string' => ':attribute :value belgilaridan kichik bo`lishi kerak.',
        'array' => ':attribute da :value dan kamroq element bo`lishi kerak.',
    ],
    'lte' => [
        'numeric' => ':attribute :value dan kichik yoki teng bo`lishi kerak.',
        'file' => ':attribute :value kilobaytdan kichik yoki teng bo`lishi kerak.',
        'string' => ':attribute :value belgilaridan kichik yoki teng bo`lishi kerak.',
        'array' => ':attribute da :value dan ortiq element bo`lmasligi kerak.',
    ],
    'max' => [
        'numeric' => ':attribute :max dan katta bo`lishi mumkin emas.',
        'file' => ':attribute :max kilobaytdan katta bo`lishi mumkin emas.',
        'string' => ':attribute :max belgilardan katta bo`lishi mumkin emas.',
        'array' => ':attribute :max dan ortiq bo`lishi mumkin emas.',
    ],
    'mimes' => ':attribute quyidagi turdagi fayl bo`lishi kerak: :values.',
    'mimetypes' => ':attribute quyidagi turdagi fayl bo`lishi kerak: :values.',
    'min' => [
        'numeric' => ':attribute kamida :min bo`lishi kerak',
        'file' => ':attribute kamida :min kilobayt bo`lishi kerak.',
        'string' => ':attribute kamida :min belgidan iborat bo`lishi kerak.',
        'array' => ':attribute da kamida :min element bo`lishi kerak.',
    ],
    'not_in' => 'Tanlangan :attribute noto`g`ri.',
    'not_regex' => ':attribute formati noto`g`ri.',
    'numeric' => ':attribute raqam bo`lishi kerak.',
    'password' => 'Parol noto`g`ri.',
    'present' => ':attribute maydoni mavjud bo`lishi kerak.',
    'regex' => ':attribute formati noto`g`ri.',
    'required' => ':attribute maydoni to`ldirilishi shart.',
    'required_if' => ':attribute maydoni :other :value bo`lganda to`ldirilishi shart.',
    'required_unless' => 'Agar :diger :values ichida bo`lmasa, :attribute maydoni to`ldirilishi shart.',
    'required_with' => ':values mavjud bo`lganda :attribute maydoni to`ldirilishi shart.',
    'required_with_all' => ':values mavjud bo`lganda :attribute maydoni to`ldirilishi shart.',
    'required_without' => ':values mavjud bo`lmaganda :attribute maydoni to`ldirilishi shart.',
    'required_without_all' => ':values dan hech biri mavjud bo`lmaganda :attribute maydoni to`ldirilishi shart.',
    'same' => ':attribute va :other mos kelishi kerak.',
    'size' => [
        'numeric' => ':attribute :size bo`lishi kerak.',
        'file' => ':attribute :size kilobayt bo`lishi kerak.',
        'string' => ':attribute :size belgilar bo`lishi kerak.',
        'array' => ':attribute da :size elementlar bo`lishi kerak.',
    ],
    'starts_with' => ':attribute quyidagilardan biri bilan boshlanishi kerak: :values.',
    'string' => ':attribute satr bo`lishi kerak.',
    'timezone' => ':attribute to`g`ri vaqt zonasi bo`lishi kerak.',
    'unique' => 'Ushbu :attribute allaqachon olingan.',
    'uploaded' => ':attribute ni yuklab bo`lmadi.',
    'url' => ':attribute  formati noto`g`ri.',
    'uuid' => ':attribute to`g`ri UUID bo`lishi kerak.',

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

    'attributes' => [],

];
