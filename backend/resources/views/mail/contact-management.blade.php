@component('mail::message')
# Gawdi Boardを運用してくれて感謝感激なし汁ぶしゃ。<br>

ユーザーがお問い合わせを送信しました。<br>
対応をお願いします。<br>

お問い合わせをしたユーザーの情報<br>
学籍番号: {{ $student_number }}<br>
ユーザーネーム: {{ $user_name }}<br>
メールアドレス: {{ $email }}<br>

お問い合わせの内容<br>
お問い合わせの種類: {{ $contact_type }}<br>
お問い合わせ本文: {{ $content }}<br>

返信が必要な場合はお問い合わせをしたユーザーのメールアドレスへ直接連絡してください。<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
