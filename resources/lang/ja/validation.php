<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      | 検証言語
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
      | 次の言語行には、バリデータークラスで使用されるデフォルトのエラーメッセージが含まれています。
      | これらの規則の中には、サイズ規則などの複数のバージョンがあります。
      | これらのメッセージのそれぞれをここで微調整してください。
    */

    'accepted'             => ':attributeが未承認です',
    'active_url'           => ':attributeは有効なURLではありません',
    'after'                => ':attributeは:dateより後の日付にしてください',
    'after_or_equal'       => ':attributeは:date以降の日付にしてください',
    'alpha'                => ':attributeは英字のみ有効です',
    'alpha_dash'           => ':attributeは「英字」「数字」「-(ダッシュ)」「_(下線)」のみ有効です',
    'alpha_num'            => ':attributeは「英字」「数字」のみ有効です',
    'array'                => ':attributeは配列タイプのみ有効です',
    'before'               => ':attributeは:dateより前の日付にしてください',
    'before_or_equal'      => ':attributeは:date以前の日付にしてください',
    'between'              => [
        'numeric' => ':attributeは:min～:maxまでの数値まで有効です',
        'file'    => ':attributeは:min～:maxキロバイトまで有効です',
        'string'  => ':attributeは:min～:max文字まで有効です',
        'array'   => ':attributeは:min～:max個まで有効です',
    ],
    'boolean'              => ':attributeの値は true もしくは false のみ有効です',
    'confirmed'            => ':attributeを確認用と一致させてください',
    'date'                 => ':attributeを存在する日付にしてください',
    'date_format'          => ':attributeを:format書式と一致させてください',
    'different'            => ':attributeを:otherと違うものにしてください',
    'digits'               => ':attributeは:digits桁で入力してください',
    'digits_between'       => ':attributeは:min～:max桁で入力してください',
    'dimensions'           => ':attributeはルールに合致する画像サイズのみ有効です',
    'distinct'             => ':attributeに重複している値があります',
    'email'                => ':attributeはメールアドレスの書式のみ有効です',
    'exists'               => ':attributeは無効な値です',
    'file'                 => ':attributeはアップロード出来ないファイルです',
    'filled'               => ':attributeに値を入力してください',
    'gt'                   => [
        'numeric' => ':attributeは:valueより大きい必要があります。',
        'file'    => ':attributeは:valueキロバイトより大きい必要があります。',
        'string'  => ':attributeは:value文字より多い必要があります。',
        'array'   => ':attributeには:value個より多くの項目が必要です。',
    ],
    'gte'                  => [
        'numeric' => ':attributeは:value以上の値である必要があります。',
        'file'    => ':attributeは:valueキロバイト以上である必要があります。',
        'string'  => ':attributeは:value文字以上で入力してください。',
        'array'   => ':attributeにはvalue個以上の項目が必要です。',
    ],
    'image'                => ':attribute画像は「jpg」「png」「bmp」「gif」「svg」のみ有効です',
    'in'                   => ':attributeは無効な値です',
    'in_array'             => ':attributeは:other と一致する必要があります',
    'integer'              => ':attributeは整数のみ有効です',
    'ip'                   => ':attributeはIPアドレスの書式のみ有効です',
    'ipv4'                 => ':attributeはIPアドレス(IPv4)の書式のみ有効です',
    'ipv6'                 => ':attributeはIPアドレス(IPv6)の書式のみ有効です',
    'json'                 => ':attributeは正しいJSON文字列のみ有効です',
    'lt'                   => [
        'numeric' => ':attributeは:value未満の値で入力してください',
        'file'    => ':attributeは:valueキロバイト未満である必要があります',
        'string'  => ':attributeは:value文字未満で入力してください',
        'array'   => ':attributeは:value未満の項目を持つ必要があります',
    ],
    'lte'                  => [
        'numeric' => ':attributeは:value以下の値で入力してください',
        'file'    => ':attributeは:valueキロバイト以下である必要があります',
        'string'  => ':attributeは:value文字以下で入力してください',
        'array'   => ':attributeは:value以上の項目を持つ必要があります',
    ],
    'max'                  => [
        'numeric' => ':attributeは:max以下の値で入力してください',
        'file'    => ':attributeは:maxKB以下のファイルのみ有効です',
        'string'  => ':attributeは:max文字以下で入力してください',
        'array'   => ':attributeは:max個以下のみ有効です',
    ],
    'mimes'                => ':attributeは:valuesタイプのみ有効です',
    'mimetypes'            => ':attributeは:valuesタイプのみ有効です',
    'min'                  => [
        'numeric' => ':attributeは:min以上の値で入力してください',
        'file'    => ':attributeは:minKB以上のファイルのみ有効です',
        'string'  => ':attributeは:min文字以上で入力してください',
        'array'   => ':attributeは:min個以上のみ有効です',
    ],
    'not_in'               => ':attributeは無効な値です',
    'not_regex'            => ':attributeはformat is invalid.',
    'numeric'              => ':attributeは数字のみ有効です',
    'present'              => ':attributeが存在しません',
    'regex'                => ':attributeは無効な値です',
    'required'             => ':attributeは必須です',
    'required_if'          => ':attributeは:otherが:valueには必須です',
    'required_unless'      => ':attributeは:otherが:valuesでなければ必須です',
    'required_with'        => ':attributeは:valuesが入力されている場合は必須です',
    'required_with_all'    => ':attributeは:valuesが入力されている場合は必須です',
    'required_without'     => ':attributeは:valuesが入力されていない場合は必須です',
    'required_without_all' => ':attributeは:valuesが入力されていない場合は必須です',
    'same'                 => ':attributeは:otherと同じ場合のみ有効です',
    'size'                 => [
        'numeric' => ':attributeは:sizeのみ有効です',
        'file'    => ':attributeは:sizeKBのみ有効です',
        'string'  => ':attributeは:size文字で入力して下さい',
        'array'   => ':attributeは:size個のみ有効です',
    ],
    'string'               => ':attributeは文字列のみ有効です',
    'timezone'             => ':attributeは正しいタイムゾーンのみ有効です',
    'unique'               => 'この:attributeは既に使用されています',
    'uploaded'             => ':attributeのアップロードに失敗しました',
    'url'                  => ':attributeは正しいURL書式のみ有効です',
    'password'             => 'パスワードが正しくありません',
    'katakana'             => ':attributeは全角カナで入力してください',
    'hankakunum'           => ':attributeは半角数字のみで入力してください',
    'text'                 => ':attributeに全角英数字を含めないでください',
    'halfalphanum'         => ':attributeは半角英数字のみで入力してください',
    'datetype'             => ':attributeはYYYY-MM-DD の形式で入力してください',
    'past'                 => ':attributeは今日以前の日付を入力してください',
    'future'               => ':attributeは明日以降の日付を入力してください',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    | カスタム検証言語
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    | ここでは、行に名前を付けるために "attribute.rule"という規則を使って属性のカスタム
    | 検証メッセージを指定することができます。 これにより、特定の属性ルールに対して特定の
    | カスタム言語行をすばやく指定できます。
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
      | カスタム検証属性
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
      | 次の言語行は、属性プレースホルダを「email」ではなく「E-Mail Address」などの
      | 読みやすいものと交換するために使用されます。
      |
    */

    'attributes' => [
        'last_name'=>'姓',
        'first_name'=>'名',
        'last_name_furigana'=>'セイ',
        'first_name_furigana'=>'メイ',
        'email'=>'メールアドレス',
        'password'=>'パスワード',
        'birthday'=>'誕生日',
        'gender'=>'性別',
        'postal_code'=>'郵便番号',
        'prefecture_id'=>'都道府県',
        'address'=>'住所(市町村以下)',
        'telephone'=>'電話番号',
        'forwarding_last_name'=>'姓',
        'forwarding_first_name'=>'名',
        'forwarding_last_name_furigana'=>'セイ',
        'forwarding_first_name_furigana'=>'メイ',
        'forwarding_postal_code'=>'郵便番号',
        'forwarding_prefecture_id'=>'都道府県',
        'forwarding_address'=>'住所(市町村以下)',
        'forwarding_telephone'=>'電話番号',
        'gender'=>'性別',
        'relationship_id'=>'お相手との関係性',
        'age'=>'年代',
        'scene_id'=>'シーン',
        'user_last_name'=>'姓',
        'user_first_name'=>'名',
        'user_last_name_furigana'=>'セイ',
        'user_first_name_furigana'=>'メイ',
        'user_postal_code'=>'郵便番号',
        'user_prefecture_id'=>'都道府県',
        'user_address'=>'住所(市町村以下)',
        'user_telephone'=>'電話番号',
        'name'=>'名前',
        'title'=>'イベント名',
        'lover_id'=>'お相手',
        'date'=>'日付',
        'is_repeat'=>'繰り返しの有無',
        'new-password'=>'新しいパスワード',
        'img_num'=>'イメージ画像',
        'image'=>'写真',
        'user_email'=>'メールアドレス',
        'today'=>'今日',
    ],

];
