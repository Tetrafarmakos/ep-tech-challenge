@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <client-show :client='@json($client)' initial-filter="{{ $filter ?? 'all' }}"></client-show>
</div>
@endsection
