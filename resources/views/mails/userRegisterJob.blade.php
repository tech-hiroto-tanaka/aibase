{{$data['hira_first_name']}}{{$data['hira_last_name']}}様<br><br>

AIBASEエントリー担当です。<br>
この度は、お申し込みいただき、誠にありがとうございます。<br><br>

以下に今回お申し込みいただいた内容を記載致します。<br>
今後の流れについては、追ってメールにてご案内させていただきます。<br><br>

□お申し込み内容<br>
・お住いのエリア　：{{$data['area_name'] ?? ''}}<br>
・お名前　　　　　：{{$data['hira_first_name']}}{{$data['hira_last_name']}}様<br>
・フリガナ　　　　：{{$data['kata_first_name']}}{{$data['kata_last_name']}}様<br>
・性別　　　　　　：{{$data['gender']}}<br>
・生年月日　　　　：{{$data['birthday']}}<br>
・メールアドレス　：{{$data['email']}}<br>
・ご連絡先電話番号：{{$data['phone_number']}}<br>
・希望就業時期　　：{{$data['desired_work']}}<br>
・経験スキル　　　：{{$data['experience_skills_from_date']}}<br>
{!! nl2br($data['experience_skills_detail']) !!}
<br>
・最寄駅　　　　　：{{$data['nearest_station_name'] ? ($data['nearest_station_name'] . '駅') : ''}}<br>
・その他ご要望　　：{!! nl2br($data['other_requests']) !!}<br><br>

経歴書をお持ちの際は、本メールにご返信頂けますとエントリーがスムーズです。<br><br>

{{$data['hira_first_name']}}{{$data['hira_last_name']}}様の希望の案件・求人が見つかるように、エントリーから契約まではもちろんのこと、<br>
契約後も経験豊富な担当者がサポートいたします。<br><br>

何卒よろしくお願いいたします。<br>
@include('include.footerMail')
