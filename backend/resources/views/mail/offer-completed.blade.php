@component('mail::message')
# Gawdi Boardをご利用いただきありがとうございます。<br>
# こちらは自動メッセージです。このメールには返信しないでください。<br>

<div>

## 募集<br>
**「{{ $title }}」**<br>
の募集主に連絡が送信されました。<br>

## 募集主の情報<br>
@component('mail::panel')
学籍番号: {{ $student_number }}<br>
ユーザーネーム: {{ $user_name }}<br>
連絡先メールアドレス: {{ $email }}<br>
@endcomponent

<br>
募集主からの返事はメールで届きます。<br>
返事が届くまでお待ちください。<br>
<br>

<font size="2">
募集主から返事が届かない場合、迷惑メールフォルダーをご確認ください。<br>
募集主が何らかの理由で返事をしない場合がありますがご了承ください。<br>
ユーザー同士のトラブルについてGawdi Board運営は一切の責任を負いかねます。相手を尊重し配慮のある会話を心がけていただきますようお願い致します。<br>
</font>

</div>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
