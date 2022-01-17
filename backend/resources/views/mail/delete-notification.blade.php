@component('mail::message')
# Gawdi Boardをご利用いただきありがとうございます。<br>
# こちらは自動メッセージです。このメールには返信しないでください。<br>

<div>

## {{ $type }}<br>
**「{{ $title }}」**<br>
の掲載終了が近づいています。。<br>

@component('mail::panel')
掲載終了日 : {{ $end_date }}<br>
@endcomponent

<br>
掲載終了日と過ぎると掲示板に表示されなくなります。<br>
さらに１週間経過すると完全に削除されますので、<br>
掲載期間を延長する場合は、{{ $profile }} より延長をお願い致します。
<br>

</div>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
