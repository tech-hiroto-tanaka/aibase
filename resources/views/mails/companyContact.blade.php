{{ $data['company_name'] }}<br>
{{ $data['contact_hira_first_name'] }} {{ $data['contact_hira_last_name'] }} 様<br>
<br>
AIBASEエントリー担当です。<br>
この度は、お申し込みいただき、誠にありがとうございます。<br>
<br>
以下に今回お申し込みいただいた内容を記載致します。<br>
今後の流れについては、追って担当者からご連絡をさせていただきます。<br>
<br>
□お申し込み内容<br>
・会社名：{{ $data['company_name'] }}<br>
・部署名：{{ $data['department_name'] }}<br>
・お名前：{{ $data['contact_hira_first_name'] }} {{ $data['contact_hira_last_name'] }}<br>
・フリガナ：{{ $data['contact_kata_first_name'] }} {{ $data['contact_kata_last_name'] }}<br>
・メールアドレス：{{ $data['email'] }}<br>
・ご連絡先電話番号：{{ $data['contact_phone_number'] }}<br>
・ご希望のエリア：{{ $data['area_name'] }}<br>
お問い合わせ内容：<br>
{!! nl2br(htmlentities($data['content'])) !!} <br>
<br>
御社のご期待に添えるよう尽力してまいります。<br>
<br>
何卒よろしくお願いいたします。
<br>
@include('include.footerMail')
