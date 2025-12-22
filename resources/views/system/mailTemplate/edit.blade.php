@extends('layouts.system')

@section('content')
    <mail-template
        :data="{{ json_encode([
            'template' => $template,
            'urlBack' => route('system.mail-template.index'),
            'urlStore' => route('system.mail-template.update', $template->id),
            'mail_masters' => $mailMasters,
            'name_layout' => '新規メールテンプレート編集',
            'isEdit' => true
        ]) }}">
    </mail-template>
@endsection
