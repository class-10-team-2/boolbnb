@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12" id="instantsearch">
            <input type="text" id="searchbox" name="" value="">
            <input type="text" id="lat" name="" value="">
            <input type="text" id="lng" name="" value="">
            <input type="text" id="address" name="" value="">
        </div>
            
        <div id="hits">

        </div>
    </div>
</div>


@endsection
