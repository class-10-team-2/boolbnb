@extends('layouts.app')

@section('content')
        {{-- <section class="search-sec"> --}}
            <div class="container">

                <div class="index-search-box">
                    <form action="{{route('guest.apartments.search')}}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row search-row index-search-row ">
                            <div class="index-ricerca-row row">
                                <div class="input-box-index">
                                    <input id="index-search" type="search" class="address-input form-control search-slt" name="address" placeholder=" Dove vuoi andare?">
                                </div>
                            </div>
                            <div class="row second-row">
                                <div class="second-row-left">
                                    <div class="input-box-index radius-box">
                                        <div class="label-index">
                                        <span>Raggio di ricerca (km)</span>
                                        </div>
                                        <input id="index-radius" class="form-control search-slt" type="number" name="radius" min="0" max="50" value="20" step="5" placeholder="Km">
                                    </div>
                                    <div class="input-box-index rooms-box">
                                        <div class="label-index">
                                            <span>Stanze</span>
                                        </div>
                                        <input id="index-rooms" class="form-control search-slt" type="number" name="rooms" min="0" max="10" value="0" placeholder="Stanze">
                                    </div>
                                    <div class="input-box-index beds-box">
                                        <div class="label-index">
                                            <span>Letti</span>
                                            </div>
                                        <input id="index-beds" class="form-control search-slt" type="number" name="beds" min="1" max="20" value="1" placeholder="Letti">
                                    </div>
                                    <div class="button-box">
                                        <button id="index-search-button" type="submit" class="btn">Cerca</button>
                                    </div>

                                </div>
                                <div class="second-row-right">
                                    <h5>Scegli i servizi</h5>
                                    <div class="service-form">
                                        @foreach ($services as $service)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input checkbox-round" name="services[]" type="checkbox" id="{{$service->name}}" value="{{$service->id}}">
                                                <label class="form-check-label" for="{{$service->name}}">{{$service->name}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input id="index-latitude" type="hidden" class="lat-input" name="latitude">
                                <input id="index-longitude" type="hidden" class="lng-input" name="longitude">
                            </div>
                        </div>
                    </form>
                </div>

                <hr class="hr-index">

                <div class="title-vetrina col-12">

                    <h3>Gli appartamenti in vetrina</h3>
                </div>
                <div class="results-container">

                    @foreach ($active_sponsorships as $active_sponsorship)
                        @if ($active_sponsorship->expiration_date > $now->toDateTimeString() && $active_sponsorship->apartment->visible == 1)
                            <div class="padding-trick">
                                <div class="card">
                                    <div class="wrap">
                                        <a href="{{route('guest.apartments.show', $active_sponsorship->apartment->id)}}" class="card-link"></a>

                                        @if ($active_sponsorship->apartment_id <= 13)
                                            <img class="card-img-top" src="{{$active_sponsorship->apartment->img_path}}" alt="{{$active_sponsorship->apartment->title}}">
                                        @else
                                            <img class="card-img-top" src="{{asset('storage/' . $active_sponsorship->apartment->img_path)}}" alt="{{$active_sponsorship->apartment->title}}">
                                        @endif

                                        <div class="card-body">
                                            <h3 class="card-title">{{$active_sponsorship->apartment->title}}</h3>
                                            <p class="card-text">{{$active_sponsorship->apartment->address}}</p>
                                            <span class="info-card"><i class="fas fa-door-open"></i>&nbsp;{{($active_sponsorship->apartment->rooms == 1) ? $active_sponsorship->apartment->rooms.' Stanza' : $active_sponsorship->apartment->rooms.' Stanze'}}</span>
                                            <span class="info-card"><i class="fas fa-bed"></i>&nbsp;{{($active_sponsorship->apartment->beds == 1) ? $active_sponsorship->apartment->beds.' Letto' : $active_sponsorship->apartment->beds.' Letti'}}</span>
                                            <span class="info-card"><i class="fas fa-shower"></i>&nbsp;{{($active_sponsorship->apartment->baths == 1) ? $active_sponsorship->apartment->baths.' Bagno' : $active_sponsorship->apartment->baths.' Bagni'}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endforeach
                </div>
            </div>


        {{-- </section> --}}




              {{-- JAVASCRIPT --}}
            <script type="text/javascript">

                $('#index-search-button').click(function () {
                    sessionStorage.setItem("address", $('#index-search').val());
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

@endsection
