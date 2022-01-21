@component('mail::message')
# Gawdi Boardをご利用いただきありがとうございます。<br>
# こちらは自動メッセージです。このメールには返信しないでください。<br>

<div>

{{ $email }}があなたのメールアドレスか認証します。<br>
下のリンクを押してメールアドレスを確認してください。<br>

{{ $link }}<br>

このメールに身に覚えがない場合は無視してください。<br>

</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
