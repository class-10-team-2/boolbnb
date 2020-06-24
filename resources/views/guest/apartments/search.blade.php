@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form>
            {{-- @method('POST')
            @csrf --}}

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
                        <input class="form-check-input" name="services[]" type="checkbox" data-service-id="{{$service->id}}" value="{{$service->id}}">
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
                sessionStorage.clear();
                $('.results-container').empty(); // svuoto div con gli appartamenti
                $('#search-input').val('');
                getSearchResults();
            });


            ///////////////////// FUNZIONI /////////////////////
            // Handlebars
            var source = $("#apartment-result-template").html();
            var apartmentTamplate = Handlebars.compile(source);
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

                var lsRadius = parseInt(sessionStorage.getItem("radius"));
                var lsBeds = parseInt(sessionStorage.getItem("beds"));
                var lsRooms = parseInt(sessionStorage.getItem("rooms"));
                var lsLatitude = parseFloat(sessionStorage.getItem("latitude"));
                var lsLongitude = parseFloat(sessionStorage.getItem("longitude"));
                // ri trasformo la stringa in un array
                var lsServicesId = JSON.parse(sessionStorage.getItem("checked"));

                $.ajax({
                    url: '/search/get-json-with-algolia-results',
                    type: 'get',
                    // dataType: "json",
                    data: {
                        radius: lsRadius,
                        beds: lsBeds,
                        rooms: lsRooms,
                        latitude: lsLatitude,
                        longitude: lsLongitude,
                        services: lsServicesId
                    },
                    success: function (response) {
                        console.log('getJsonFromIndex: ', response);

                        // compilo gli input con i valori passati della index
                        $('#radius').val(lsRadius);
                        $('#rooms').val(lsRooms);
                        $('#beds').val(lsBeds);
                        lsServicesId.forEach((serviceId, i) => { // i -> indice dell'array
                            $('input[data-service-id=' + serviceId + ']').prop('checked', true);
                        });


                        // rendering dei risultati con handlebars
                        for (var i = 0; i < response.length; i++){
                            var apartment = response[i];
                            console.log(apartment);
                            var apartmentData = {
                                img_path: apartment.img_path,
                                address: apartment.address,
                                title: apartment.title,
                                rooms: apartment.rooms,
                                beds: apartment.beds,
                                baths: apartment.baths
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
                    // url: '/search/get-json-with-algolia-results',
                    url: '/search-highlights',
                    type: 'get',
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

                        for (var i = 0; i < response.length; i++){
                            var apartment = response[i];
                            console.log(apartment);
                            var apartmentData = {
                                img_path: apartment.img_path,
                                address: apartment.address,
                                title: apartment.title,
                                rooms: apartment.rooms,
                                beds: apartment.beds,
                                baths: apartment.baths
                            };

                            var apartmentHTML = apartmentTamplate(apartmentData);
                            $('.results-container').append(apartmentHTML);
                        }
                    },
                    error: function (response) {
                        console.log('getSearchResults Error:', response);
                    }
                });
            }
        </script>

</div>

@endsection
