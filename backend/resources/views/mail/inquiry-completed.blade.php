@component('mail::message')
# Gawdi Boardをご利用いただきありがとうございます。<br>
# こちらは自動メッセージです。このメールには返信しないでください。<br>

<div>

お問い合わせを承りました。<br>
運営が対応するまで今しばらくお待ちください。<br>

<font size="2">
Gawdi BoardはECC学内の有志によって運営されています。対応に時間がかかる場合がありますがご了承ください。<br>
運営からの返信がある場合はこのメールアドレス宛に送信されます。<br>
</font>

</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
