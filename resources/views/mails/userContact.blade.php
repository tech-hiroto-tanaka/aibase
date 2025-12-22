[AIBASE] お問い合わせ完了のお知らせ<br><br>

お世話になっております。<br>
AIBASE運営管理部です。AIBASEに関するお問い合わせありがとうございました。<br><br>

以下の内容でお問い合わせを受付いたしました。<br><br>

担当よりご連絡致しますので今しばらくお待ちくださいませ。<br><br>

▼お問い合わせ内容▼<br>
氏名：{{ $data['hira_first_name'] }} {{ $data['hira_last_name'] }} <br>
メールアドレス：{{ $data['email'] }}<br>
お問い合わせ内容：<br>
{!! nl2br(htmlentities($data['content'])) !!} <br>
@include('include.footerMail')
