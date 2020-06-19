@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            {{-- <form class="" action="{{route('getinputfields')}}" method="POST">
                @method('POST')
                @csrf
                <input type="search" class="address-input" name="home-search-input" placeholder="Dove vuoi andare?" />
                <input type="text" class="lat-input">
                <input type="text" class="lng-input">

                <input class="btn btn-primary" type="submit" name="" value="Cerca">

            </form> --}}
            <form class="" action="{{route('guest.apartment.search')}}" method="POST">
                @method('POST')
                @csrf
                <input type="search" class="address-input" name="address" placeholder="Dove vuoi andare?" />
                <input type="text" class="lat-input" name="lat">
                <input type="text" class="lng-input" name="lng">

                <input class="btn btn-primary" type="submit" name="" value="Cerca">

            </form>
        </div>

    </div>
</div>


@endsection
