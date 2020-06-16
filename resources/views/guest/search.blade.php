@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 instantsearch"></div>
            <input type="text" id="searchbox" name="" value="">
        <div id="hits"></div>
    </div>
</div>


@endsection
