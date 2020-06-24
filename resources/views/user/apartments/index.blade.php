@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @foreach ($apartments as $apartment)
        <div class="col-4">
            <div class="card" style="width: 18rem;">
              {{-- <img src="{{asset('storage/' . $apartment->img_path)}}" class="card-img-top" alt="{{$apartment->title}}"> --}}
              <img src="{{asset($apartment->img_path)}}"" class="card-img-top" alt="{{$apartment->title}}">
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

                <a href="{{route('user.apartments.show', $apartment->id)}}" class="btn btn-primary">Gestisci</a>
              </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection
