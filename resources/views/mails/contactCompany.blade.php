{{ $data['company_name'] }} <br>
{{ $data['contact_hira_first_name'] }} {{ $data['contact_hira_last_name']}}様 <br><br>

AIBASEエントリー担当です。<br>
この度は、お申し込みいただき、誠にありがとうございます。<br><br>

以下に今回お申し込みいただいた内容を記載致します。<br>
今後の流れについては、追って担当者からご連絡をさせていただきます。<br><br>

□お申し込み内容<br>
・会社名：{{ $data['company_name'] }} <br>
・部署名：{{ $data['department_name'] }} <br>
・お名前：{{ $data['contact_hira_first_name'] }} {{ $data['contact_hira_last_name'] }}  <br>
・フリガナ：{{ $data['contact_kata_first_name'] }} {{ $data['contact_kata_last_name'] }} <br>
・メールアドレス：{{ $data['email'] }} <br>
・ご連絡先電話番号：{{ $data['contact_phone_number'] }} <br>
・ご希望のエリア：{{ $data['area_name'] }} <br>
・お問い合わせ内容：{!! nl2br(htmlentities($data['contact_content'])) !!} <br><br>

御社のご期待に添えるよう尽力してまいります。<br><br>

何卒よろしくお願いいたします。<br><br>

———————————————————————<br>
サービス名：AIBASE <br>
URL：https://tec-aibase.com <br>
メールアドレス：info@tec-aibase.com <br><br>

【運営元：株式会社テックエデュケイションカンパニー】 <br>
住所：大阪本社<br>
〒550-0005 大阪市西区西本町1-2-1 AXIS本町ビル7F <br>
TEL：06-7505-7510 <br>
営業時間：平日 9時～18時 <br>
——————————————————————— <br>
