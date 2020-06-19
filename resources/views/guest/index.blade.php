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
                <div class="form-group">
                    <input type="search" class="address-input" name="address" placeholder="Dove vuoi andare?" />
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="range">Raggio di ricerca</label>
                        <input id="range" class="form-control" type="number" name="range" min="1" max="50" value="20">
                    </div>
                    <div class="col">
                        <label for="range">Minimo di stanze</label>
                        <input id="range" class="form-control" type="number" name="rooms" min="0" max="10" value="1">
                    </div>
                    <div class="col">
                        <label for="range">Minimo posti letto</label>
                        <input id="range" class="form-control" type="number" name="beds" min="1" max="20" value="1">
                    </div>
                </div>

                <div class="form-group">
                    @foreach ($services as $service)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="services[]" type="checkbox" id="{{$service->name}}" value="{{$service->id}}">
                            <label class="form-check-label" for="{{$service->name}}">{{$service->name}}</label>
                        </div>
                    @endforeach
                </div>

                <input type="hidden" class="lat-input" name="lat">
                <input type="hidden" class="lng-input" name="lng">

                <input class="btn btn-primary" type="submit" name="" value="Cerca">

            </form>
        </div>

    </div>
</div>


@endsection
