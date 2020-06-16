@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 instantsearch">

            {{-- <input type="search" class="address-input" placeholder="Dove vuoi andare?" />
            <input type="text" class="lat-input">   
            <input type="text" class="lng-input">    --}}
        </div>
        <div id="hits">
            
        </div>
    </div>
</div>

    
@endsection
