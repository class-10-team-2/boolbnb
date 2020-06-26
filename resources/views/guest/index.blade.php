@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-12">

            <form action="{{route('guest.apartments.search')}}" method="GET">
            {{-- </form> --}}
                <div class="form-group">
                    <input id="index-search" type="search" class="address-input" name="address" placeholder="Dove vuoi andare?" />
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="radius">Raggio di ricerca</label>
                        <input id="index-radius" class="form-control" type="number" name="radius" min="1" max="50" value="20">
                    </div>
                    <div class="col">
                        <label for="rooms">Minimo di stanze</label>
                        <input id="index-rooms" class="form-control" type="number" name="rooms" min="0" max="10" value="1">
                    </div>
                    <div class="col">
                        <label for="beds">Minimo posti letto</label>
                        <input id="index-beds" class="form-control" type="number" name="beds" min="1" max="20" value="1">
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

                <input id="index-latitude" type="hidden" class="lat-input" name="latitude">
                <input id="index-longitude" type="hidden" class="lng-input" name="longitude">

                <input id="index-search-button" class="btn btn-primary" type="submit" name="" value="Cerca">
            </form>

        </div>

        {{-- JAVASCRIPT --}}
        <script type="text/javascript">

            $(document).on('click', '#index-search-button', function () {
                sessionStorage.setItem("rooms", $('#index-rooms').val());
                sessionStorage.setItem("beds", $('#index-beds').val());
                sessionStorage.setItem("radius", $('#index-radius').val());
                sessionStorage.setItem("latitude", $('#index-latitude').val());
                sessionStorage.setItem("longitude", $('#index-longitude').val());

                // pusho in un array tutti i valori (gli id dei servizi) dei checkbox checked
                var checked = [];
                $('input').each(function(){
                    if ($(this).is(':checked')) {
                        checked.push($(this).val());
                    }
                });

                console.log(checked);

                // trasformo l'array in una stringa
                var jsonChecked = JSON.stringify(checked);
                sessionStorage.setItem("checked", jsonChecked);
            });

        </script>
    </div>
</div>


@endsection
