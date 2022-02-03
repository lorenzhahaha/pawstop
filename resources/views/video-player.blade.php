@extends('layouts.main')

@section('content')
<video-player-component :url="{{ $url }}"></video-player-component>
@endsection
