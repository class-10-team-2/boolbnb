@extends('layouts.app')

@section('content')
        <section class="search-sec">
            <div class="container">
                <form action="{{route('guest.apartments.search')}}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-12  col-sm-12 col-12 p-0">

                                    <input id="index-search" type="search" class="address-input form-control search-slt" name="address" placeholder="Dove vuoi andare?" />
                                </div>
                                <div class="col-lg-1  col-md-4 col-sm-4 col-4 p-0">

                                    <input id="index-radius" class="form-control search-slt" type="number" name="radius" min="0" max="50" value="20" step="5" placeholder="Km">
                                </div>
                                <div class="col-lg-1 col-md-4 col-sm-4 col-4 p-0">

                                    <input id="index-rooms" class="form-control search-slt" type="number" name="rooms" min="0" max="10" value="0" placeholder="Stanze">
                                </div>
                                <div class="col-lg-1 col-md-4 col-sm-4 col-4 p-0">

                                    <input id="index-beds" class="form-control search-slt" type="number" name="beds" min="1" max="20" value="1" placeholder="Letti">
                                </div>
                                {{-- <div class="col-lg-1 col-md-3 col-sm-3 col-3 p-0">

                                    <input id="index-baths" class="form-control search-slt" type="number" name="baths" min="1" max="20" placeholder="Bagni">
                                </div> --}}
                                <input id="index-latitude" type="hidden" class="lat-input" name="latitude">
                                <input id="index-longitude" type="hidden" class="lng-input" name="longitude">
                                <div class="col-lg-4 col-md-12  col-sm-12 col-12 p-0">

                                    <button id="index-search-button" type="submit" class="btn btn-danger wrn-btn">Search</button>
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
        <div class="row">
           
                @foreach ($active_sponsorships as $active_sponsorship)
                    @if ($active_sponsorship->expiration_date > $now->toDateTimeString())                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 card-container">
                            <div class="card apartments-card" >
                              {{-- <img src="{{asset('storage/' . $apartment->img_path)}}" class="card-img-top" alt="{{$apartment->title}}"> --}}
                              @if ($active_sponsorship->apartment_id <= 13)
                              <div class="row row-img">
                                <img class="card-img-top img-thumbnail" src="{{$active_sponsorship->apartment->img_path}}" alt="{{$active_sponsorship->apartment->title}}">
                              </div>
                              @else
                              <div class="row row-img">
                                <img class="card-img-top img-thumbnail" src="{{asset('storage/' . $active_sponsorship->apartment->img_path)}}" alt="{{$active_sponsorship->apartment->title}}">
                              </div>
                              @endif
                              <div class="card-body">
                            <h5 class="card-title">{{$active_sponsorship->apartment->title}}</h5>
                                {{-- <div class="">
                                    <span>{{$apartment->rooms}}</span>

                                </div>
                                <div class="">
                                    <span>{{$apartment->baths}}</span>

                                </div>
                                <div class="">
                                    <span>{{$apartment->beds}}</span>

                                </div>
                                <div class="">
                                    <span>{{$apartment->mq}}</span>

                                </div>

                                @foreach ($apartment->services as $service)

                                    <div class="">
                                        <p> {{$service->name}}</p>

                                    </div>

                                @endforeach --}}
                                <div class="">
                                    <p>{{$active_sponsorship->apartment->address}}</p>

                                </div>

                                <a href="{{route('guest.apartments.show', $active_sponsorship->apartment->id)}}" class="btn btn-primary btn-show">Gestisci</a>
                              </div>

                            </div>

                        </div>

                    @endif

                @endforeach




        </div>

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
    </div>
</div>


@endsection
