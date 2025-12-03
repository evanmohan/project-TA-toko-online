@extends('home.app')

@section('content')
<div class="container py-4 d-flex gap-3">

    {{-- SIDEBAR --}}
    @include('user.profile-sidebar')

    {{-- CONTENT + TABS --}}
    @include('user.profile-tabs', ['tab' => request('tab', 'biodata')])

</div>
@endsection
