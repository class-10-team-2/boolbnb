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
    @include('layouts.apartment-result-handlebars-seed')
    @include('layouts.apartment-sponsored-result-handlebars')
    @include('layouts.apartment-sponsored-result-handlebars-seed')


        {{-- JAVASCRIPT --}}
        <script type="text/javascript">

            getSponsoredFromIndex();
            getJsonFromIndex();

            $(document).on('click', '#search-button', function () {
                sessionStorage.clear();
                $('.results-container').empty(); // svuoto div con gli appartamenti
                // $('#search-input').val('');
                getSponsored();
                getSearchResults();
            });


            ///////////////////// FUNZIONI /////////////////////
            // Template Handlebars per gli appartamenti non sponsorizzati
            var apartmentSource = $("#apartment-result-template").html();
            var apartmentTamplate = Handlebars.compile(apartmentSource);

            var apartmentSourceSeed = $("#apartment-result-template-seed").html();
            var apartmentTamplateSeed = Handlebars.compile(apartmentSourceSeed);
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

                var lsAddress = sessionStorage.getItem("address");
                var lsRadius = parseInt(sessionStorage.getItem("radius"));
                var lsBeds = parseInt(sessionStorage.getItem("beds"));
                var lsRooms = parseInt(sessionStorage.getItem("rooms"));
                var lsLatitude = parseFloat(sessionStorage.getItem("latitude"));
                var lsLongitude = parseFloat(sessionStorage.getItem("longitude"));
                // ri trasformo la stringa in un array
                var lsServicesId = JSON.parse(sessionStorage.getItem("checked"));
                // console.log(lsServicesId);
                $.ajax({
                    url: '/search/get-json-results',
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

                        var objectToArray =  response.map(function(v) {
                                                  return Object.keys(v).length;
                                                });

                        if (objectToArray.length > 1){
                            response.sort(function (a, b) {
                                return a.distance - b.distance;
                            });
                        }

                        // compilo gli input con i valori passati della index
                        $('#search-input').val(lsAddress);
                        $('#latitude').val(lsLatitude);
                        $('#longitude').val(lsLongitude);
                        $('#radius').val(lsRadius);
                        $('#rooms').val(lsRooms);
                        $('#beds').val(lsBeds);
                        lsServicesId.forEach((serviceId, i) => { // i -> indice dell'array
                            $('input[data-service-id=' + serviceId + ']').prop('checked', true);
                        });

                        // rendering dei risultati con handlebars
                        for (var i = 0; i < objectToArray.length; i++){

                            var apartment = response[i];
                            console.log(apartment);

                            var apartmentData = {
                                img_path: apartment.img_path,
                                address: apartment.address,
                                title: apartment.title,
                                rooms: apartment.rooms,
                                beds: apartment.beds,
                                baths: apartment.baths,
                                id: apartment.id
                            };

                            if (apartment.id <= 13) {
                                var apartmentHTMLSeed = apartmentTamplateSeed(apartmentData);
                                $('.results-container').append(apartmentHTMLSeed);

                            } else {
                                var apartmentHTML = apartmentTamplate(apartmentData);
                                $('.results-container').append(apartmentHTML);

                            }
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

                // pusho in un array tutti i valori (cioè gli id dei servizi) dei checkbox checked
                var checked = [];
                $('input[data-service-id]').each(function(){
                    if ($(this).is(':checked')) {
                        checked.push($(this).val());
                    }
                });

                console.log('checked:', checked);

                $.ajax({
                    url: '/search/get-json-results',
                    type: 'get',
                    // dataType: "json",
                    data: {
                        radius: parseInt($('#radius').val()),
                        beds: parseInt($('#beds').val()),
                        rooms: parseInt($('#rooms').val()),
                        latitude: parseFloat($('#latitude').val()),
                        longitude: parseFloat($('#longitude').val()),
                        services: checked,
                        is_sponsored: 0 // false
                    },
                    success: function (response) {
                        console.log('getSearchResults: ', response);

                        // ordinati dalla distanza più breve a quella più lunga
                        var objectToArray =  response.map(function(v) {
                                                  return Object.keys(v).length;
                                                });

                        if (objectToArray.length > 1){
                            response.sort(function (a, b) {
                                return a.distance - b.distance;
                            });
                        }

                        // console.log('ordered: ', response);

                        for (var i = 0; i < objectToArray.length; i++){

                            var apartment = response[i];
                            console.log(apartment);

                            var apartmentData = {
                                img_path: apartment.img_path,
                                address: apartment.address,
                                title: apartment.title,
                                rooms: apartment.rooms,
                                beds: apartment.beds,
                                baths: apartment.baths,
                                id: apartment.id
                            };
                            if (apartment.id <= 13) {
                                var apartmentHTMLSeed = apartmentTamplateSeed(apartmentData);
                                $('.results-container').append(apartmentHTMLSeed);

                            } else {
                                var apartmentHTML = apartmentTamplate(apartmentData);
                                $('.results-container').append(apartmentHTML);

                            }

                        }
                    },
                    error: function (response) {
                        console.log('getSearchResults Error:', response);
                    }
                });
            }

            // Template Handlebars per gli appartamenti sponsorizzati
            var sponsoredApartmentSource = $("#apartment-sponsored-result-template").html();
            var sponsoredApartmentTamplate = Handlebars.compile(sponsoredApartmentSource);

            var sponsoredApartmentSourceSeed = $("#apartment-sponsored-result-template-seed").html();
            var sponsoredApartmentTamplateSeed = Handlebars.compile(sponsoredApartmentSourceSeed);

            // restituisce un json con gli appartamenti sponsorizzati e filtrati in base agli input della pagina di ricerca
            function getSponsored() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    }
                });

                $.ajax({
                    // url: '/search/get-json-with-algolia-results',
                    url: '/search/get-json-results',
                    type: 'get',
                    // dataType: "json",
                    data: {
                        // radius: $('#radius').val(),
                        beds: $('#rooms').val(),
                        rooms: $('#beds').val(),
                        latitude: $('#latitude').val(),
                        longitude: $('#longitude').val(),
                        radius: 50,
                        is_sponsored: 1 // true
                    },
                    success: function (response) {
                        console.log('getSponsored: ', response);

                        // trasformiamo il response in un array
                        var objectToArray =  response.map(function(v) {
                                                  return Object.keys(v).length;
                                                });

                        if (objectToArray.length > 1){
                            response.sort(function (a, b) {
                                return a.distance - b.distance;
                            });
                        }

                        for (var i = 0; i < objectToArray.length; i++){

                            var apartment = response[i];
                            console.log(apartment);

                            var apartmentData = {
                                img_path: apartment.img_path,
                                address: apartment.address,
                                title: apartment.title,
                                rooms: apartment.rooms,
                                beds: apartment.beds,
                                baths: apartment.baths,
                                id: apartment.id
                            };

                            if (apartment.id <= 13) {
                                var sponsoredApartmentHTMLSeed = sponsoredApartmentTamplateSeed(apartmentData);
                            $('.results-container').append(sponsoredApartmentHTMLSeed);
                            } else {
                                var sponsoredApartmentHTML = sponsoredApartmentTamplate(apartmentData);
                            $('.results-container').append(sponsoredApartmentHTML);
                            }


                        }
                    },
                    error: function (response) {
                        console.log('getSponsored Error:', response);
                    }
                });
            }

            // restituisce un json con gli appartamenti sponsorizzati e filtrati in base agli input della index
            function getSponsoredFromIndex() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    }
                });

                var lsAddress = sessionStorage.getItem("address");
                var lsBeds = parseInt(sessionStorage.getItem("beds"));
                var lsRooms = parseInt(sessionStorage.getItem("rooms"));
                var lsLatitude = parseFloat(sessionStorage.getItem("latitude"));
                var lsLongitude = parseFloat(sessionStorage.getItem("longitude"));
                // ri trasformo la stringa in un array
                var lsServicesId = JSON.parse(sessionStorage.getItem("checked"));
                // console.log(lsServicesId);
                $.ajax({
                    url: '/search/get-json-results',
                    type: 'get',
                    // dataType: "json",
                    data: {
                        radius: 50,
                        beds: lsBeds,
                        rooms: lsRooms,
                        latitude: lsLatitude,
                        longitude: lsLongitude,
                        services: lsServicesId,
                        is_sponsored: 1 // true
                    },
                    success: function (response) {
                        console.log('getSponsoredFromIndex: ', response);

                        var objectToArray =  response.map(function(v) {
                                                  return Object.keys(v).length;
                                                });

                        if (objectToArray.length > 1){
                            response.sort(function (a, b) {
                                return a.distance - b.distance;
                            });
                        }

                        lsServicesId.forEach((serviceId, i) => { // i -> indice dell'array
                            $('input[data-service-id=' + serviceId + ']').prop('checked', true);
                        });

                        // rendering dei risultati con handlebars
                        for (var i = 0; i < objectToArray.length; i++){

                            var apartment = response[i];
                            console.log(apartment);

                            var apartmentData = {
                                img_path: apartment.img_path,
                                address: apartment.address,
                                title: apartment.title,
                                rooms: apartment.rooms,
                                beds: apartment.beds,
                                baths: apartment.baths,
                                id: apartment.id
                            };

                            if (apartment.id <= 13) {
                                var sponsoredApartmentHTMLSeed = sponsoredApartmentTamplateSeed(apartmentData);
                            $('.results-container').append(sponsoredApartmentHTMLSeed);
                            } else {
                                var sponsoredApartmentHTML = sponsoredApartmentTamplate(apartmentData);
                            $('.results-container').append(sponsoredApartmentHTML);
                            }
                        }
                    },
                    error: function (response) {
                        console.log('getJsonFromIndex Error:', response);
                    }
                });
            }

        </script>

</div>

@endsection
