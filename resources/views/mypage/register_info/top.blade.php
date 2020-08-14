@extends('layouts.base')

@section('pagename')
    登録情報
@endsection

@include('layouts.head')

@include('layouts.header')

@section('content')
    <section id="register_info" class="normal_section">
        <h1>登録情報</h1>
        <table cellspacing="4">
            <tr>
                <th>姓</th>
                <td>{{ Auth::user()->last_name }}</td>
            </tr>
            <tr>
                <th>名</th>
                <td>{{ Auth::user()->first_name }}</td>
            </tr>
            <tr>
                <th>セイ</th>
                <td>{{ Auth::user()->last_name_furigana }}</td>
            </tr>
            <tr>
                <th>メイ</th>
                <td>{{ Auth::user()->first_name_furigana }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <th>パスワード</th>
                <td>(プライバシー保護のため非表示)</td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td>{{ Auth::user()->birthday->format('Y/m/d') }}</td>
            </tr>
            <tr>
                <th>性別</th>
                <td>
                    @if (Auth::user()->gender===0)
                        男性
                    @elseif(Auth::user()->gender===1)
                        女性
                    @elseif(Auth::user()->gender===2)
                        その他
                    @endif
                </td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>@if (Auth::user()->prefecture_id!=null){{ Auth::user()->postal_code }} @else 未設定 @endif</td>
            </tr>
            <tr>
                <th>都道府県</th>
                <td>@if(Auth::user()->prefecture_id!=null) {{ Auth::user()->prefecture->name  }} @else 未設定 @endif</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>@if (Auth::user()->prefecture_id!=null){{ Auth::user()->address }} @else 未設定 @endif</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>@if (Auth::user()->prefecture_id!=null){{ Auth::user()->telephone }} @else 未設定 @endif</td>
            </tr>
        </table>
        <h2 class="submit_a"><a href="edit">登録情報を編集する</a></h2>
        <h2 class="submit_a"><a href="delete" onClick="return confirm('退会すると登録している情報は削除され、二度と復元できなくなってしまいます。\n本当によろしいですか？');">tanp_missionを退会する</a></h2>
    </section>
@endsection

@include('layouts.footer')