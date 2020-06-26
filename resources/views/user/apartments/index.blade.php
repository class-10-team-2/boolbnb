@extends('layouts.app')
@section('content')
<div class="container">
    <div class="title-margin">
        <h2>Gestisci i tuoi appartmenti</h2>

    </div>
    <div class="row">
        @if ($apartments->count() == 0)
            <p>Non hai ancora registrato nessun appartamento</p>
            <a class="btn btn-primary" href="{{route('user.apartments.create')}}">Inserisci il tuo appartmento</a>
        @endif
        @foreach ($apartments as $apartment)
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 card-container">
            <div class="card" >
              {{-- <img src="{{asset('storage/' . $apartment->img_path)}}" class="card-img-top" alt="{{$apartment->title}}"> --}}
              <img src="{{asset('storage/' . $apartment->img_path)}}"" class="card-img-top img-thumbnail" alt="{{$apartment->title}}">
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
