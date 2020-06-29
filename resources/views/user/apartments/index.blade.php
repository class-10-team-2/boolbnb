@extends('layouts.app')
@section('content')
<div class="container">
    @if ($apartments->count() != 0)
    <div class="title-margin">
        <h2>Gestisci i tuoi appartmenti</h2>
        <a class="btn btn-ptimary btn-space" href="/user/apartments/create">Inserisci un nuovo appartamento</a>
    </div>
    @else
        <div class="no-apt">
            <p>Non hai ancora registrato nessun appartamento</p>

        </div>
        <div class="no-apt-btn">
            <a class="btn btn-primary btn-space" href="{{route('user.apartments.create')}}">Inserisci il tuo appartmento</a>
        </div>
    @endif
    <div class="row">

        @foreach ($apartments as $apartment)
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 card-container">
            <div class="card apartments-card" >
                @if ($apartment->id <= 13)
                <div class="row row-img">
                  <img class="apt-image" src="{{$apartment->img_path}}" alt="{{$apartment->title}}">
                </div> 
                @else
                <div class="row row-img">
                  <img class="apt-image" src="{{asset('storage/' . $apartment->img_path)}}" alt="{{$apartment->title}}">
                </div>    
                @endif
              <div class="card-body">
            <h5 class="card-title">{{$apartment->title}}</h5>
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
                    <p>{{$apartment->address}}</p>

                </div>

                <a href="{{route('user.apartments.show', $apartment->id)}}" class="btn btn-primary btn-show">Gestisci</a>
              </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection
