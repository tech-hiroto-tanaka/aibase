@extends('layouts.system')

@section('content')
<item-master-create :data="{{ json_encode([
    'urlStore' => route('system.item-master.store', ['type' => $type]),
    'title' => $title
]) }}"></item-master-create>
@endsection
