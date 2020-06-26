@extends('layouts.app')

@section('content')
    <section class="search-sec">
        <div class="container">
            <form action="{{route('guest.apartments.search')}}" method="GET">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-12  col-sm-12 col-12 p-0">

                                <input id="index-search" type="search" class="address-input form-control search-slt" name="address" placeholder="Dove vuoi andare?" />
                            </div>
                            <div class="col-lg-1  col-md-3 col-sm-3 col-3 p-0">

                                <input id="index-radius" class="form-control search-slt" type="number" name="radius" min="1" max="50" placeholder="Mq">
                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-3 col-3 p-0">

                                <input id="index-rooms" class="form-control search-slt" type="number" name="rooms" min="0" max="10" placeholder="Stanze">
                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-3 col-3 p-0">

                                <input id="index-beds" class="form-control search-slt" type="number" name="beds" min="1" max="20"  placeholder="Letti">
                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-3 col-3 p-0">

                                <input id="index-baths" class="form-control search-slt" type="number" name="baths" min="1" max="20" placeholder="Bagni">
                            </div>
                            <input id="index-latitude" type="hidden" class="lat-input" name="latitude">
                            <input id="index-longitude" type="hidden" class="lng-input" name="longitude">
                            <div class="col-lg-4 col-md-12  col-sm-12 col-12 p-0">

                                <button type="submit" class="btn btn-danger wrn-btn">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" service-form">
                    @foreach ($services as $service)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="services[]" type="checkbox" id="{{$service->name}}" value="{{$service->id}}">
                            <label class="form-check-label" for="{{$service->name}}">{{$service->name}}</label>
                        </div>
                    @endforeach
                </div>
            </form>



    </section>

    <div class="results-container">

    </div>

    @include('layouts.apartment-result-handlebars')
    @include('layouts.apartment-sponsored-result-handlebars')


        {{-- JAVASCRIPT --}}
        <script type="text/javascript">

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
                console.log(lsServicesId);
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

                // pusho in un array tutti i valori (cioè gli id dei servizi) dei checkbox checked
                var checked = [];
                $('input[data-service-id]').each(function(){
                    if ($(this).is(':checked')) {
                        checked.push($(this).val());
                    }
                });

                console.log('checked:', checked);

                $.ajax({
                    url: '/search/get-json-with-algolia-results',
                    type: 'get',
                    // dataType: "json",
                    data: {
                        radius: parseInt($('#radius').val()),
                        beds: parseInt($('#beds').val()),
                        rooms: parseInt($('#rooms').val()),
                        latitude: parseFloat($('#latitude').val()),
                        longitude: parseFloat($('#longitude').val()),
                        services: checked
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

            // Template Handlebars per gli appartamenti sponsorizzati
            var sponsoredApartmentSource = $("#apartment-sponsored-result-template").html();
            var sponsoredApartmentTamplate = Handlebars.compile(sponsoredApartmentSource);

            // restituisce un json con i risultati filtrati da algolia
            function getSponsored() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    }
                });

                $.ajax({
                    // url: '/search/get-json-with-algolia-results',
                    url: '/search-sponsored',
                    type: 'get',
                    // dataType: "json",
                    data: {
                        // radius: $('#radius').val(),
                        beds: $('#rooms').val(),
                        rooms: $('#beds').val(),
                        latitude: $('#latitude').val(),
                        longitude: $('#longitude').val(),

                    },
                    success: function (response) {
                        console.log('getSponsored: ', response);

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

                            var sponsoredApartmentHTML = sponsoredApartmentTamplate(apartmentData);
                            $('.results-container').append(sponsoredApartmentHTML);
                        }
                    },
                    error: function (response) {
                        console.log('getSponsored Error:', response);
                    }
                });
            }
        </script>

</div>

@endsection
