@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form>
            @method('POST')
            @csrf

            <div class="form-group">
                <input id="search-input" type="search" class="address-input" name="address" placeholder="Dove vuoi andare?" />
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="radius">Raggio di ricerca</label>
                    <input id="radius" class="form-control" type="number" name="radius" min="1" max="50" value="20">
                </div>
                <div class="col">
                    <label for="rooms">Minimo di stanze</label>
                    <input id="rooms" class="form-control" type="number" name="rooms" min="0" max="10" value="1">
                </div>
                <div class="col">
                    <label for="beds">Minimo posti letto</label>
                    <input id="beds" class="form-control" type="number" name="beds" min="1" max="20" value="1">
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

            <input id="latitude" type="hidden" class="lat-input" name="latitude">
            <input id="longitude" type="hidden" class="lng-input" name="longitude">

            <button id="search-button" class="btn btn-primary" type="button">Cerca</button>
        </form>

    </div>

    <div class="results-container">

    </div>

    @include('layouts.apartment-result-handlebars')

        {{-- JAVASCRIPT --}}
        <script type="text/javascript">


            getJsonFromIndex();

            $(document).on('click', '#search-button', function () {
                $('#search-input').val('');
                getSearchResults();
            });

            console.log(localStorage.getItem("latitude"));
            console.log(localStorage.getItem("longitude"));
            console.log(localStorage.getItem("beds"));
            console.log(localStorage.getItem("rooms"));
            console.log(localStorage.getItem("radius"));


            // console.log('latitude:', parseFloat(lsLatitude));
            // lsLatitude = parseFloat(lsLatitude);
            // console.log(typeof(lsLatitude));
            //
            // console.log('longitude:', parseFloat(lsLongitude));

            ///////////////////// FUNZIONI /////////////////////

            /**
             * Nel 'data' prende valori degli input del form di ricerca della home page
             * che sono stati salvati nel local storage.
             * Chiama il metodo search() di Algolia nel SearchController.
             * Restituisce un json
             */
            function getJsonFromIndex() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    }
                });

                var lsRadius = parseInt(localStorage.getItem("radius"));
                var lsBeds = parseInt(localStorage.getItem("beds"));
                var lsRooms = parseInt(localStorage.getItem("rooms"));
                var lsLatitude = parseFloat(localStorage.getItem("latitude"));
                var lsLongitude = parseFloat(localStorage.getItem("longitude"));

                // Handlebars
                var source = $("#apartment-result-template").html();
                var apartmentTamplate = Handlebars.compile(source);

                $.ajax({
                    url: '/search/get-json-with-algolia-results',
                    type: 'get',
                    // async:false,
                    // dataType: "json",
                    data: {
                        radius: lsRadius,
                        beds: lsBeds,
                        rooms: lsRooms,
                        latitude: lsLatitude,
                        longitude: lsLongitude,

                    },
                    success: function (response) {
                        console.log('getJsonFromIndex: ', response);

                        for (var i = 0; i < response.length; i++){
                            var apartment = response[i];
                            console.log(apartment);
                            var apartmentData = {
                                title: apartment.title,
                                // aggiungere altri campi
                            };

                            var apartmentHTML = apartmentTamplate(apartmentData);
                            $('.results-container').append(apartmentHTML);
                        }


                    },
                    error: function (response) {
                        console.log('getJsonFromIndex Error:', response);
                    }
                });
            }


            // restituisce un json con i risultati filtrati da algolia
            function getSearchResults() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    }
                });

                $.ajax({
                    url: '/search/get-json-with-algolia-results',
                    type: 'get',
                    // async:false,
                    // dataType: "json",
                    data: {
                        radius: $('#radius').val(),
                        beds: $('#rooms').val(),
                        rooms: $('#beds').val(),
                        latitude: $('#latitude').val(),
                        longitude: $('#longitude').val(),

                    },
                    success: function (response) {
                        console.log('getSearchResults: ', response);
                    },
                    error: function (response) {
                        console.log('getSearchResults Error:', response);
                    }
                });
            }
        </script>
        {{-- <div class="col-12" id="instantsearch">
            <input type="text" id="searchbox" name="" value="">
            <input type="text" id="lat" name="" value="">
            <input type="text" id="lng" name="" value="">
            <input type="text" id="address" name="" value="">
        </div>

        <div id="hits">

        </div> --}}

</div>


@endsection
