@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card" style="width: 18rem;">
              <img src="{{asset('storage/' . $apartment->img_path)}}" class="card-img-top" alt="{{$apartment->title}}">
              <div class="card-body">
                <h5 class="card-title">{{$apartment->title}}</h5>
                <div class="">
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
                <div class="">
                    <p>{{$apartment->address}}</p>

                </div>
                @foreach ($apartment->services as $service)

                    <div class="">
                        <p> {{$service->name}}</p>

                    </div>

                @endforeach

                <a href="{{route('user.apartments.edit', $apartment->id)}}" class="btn btn-primary">Modifica</a>
                <form class="" action="{{route('user.apartments.destroy', $apartment->id)}}" method="post">
                    @method('DELETE')
                    @csrf
                    <input class="btn btn-danger" type="submit" name="" value="ELIMINA">

                </form>
              </div>
            </div>

        </div>

    </div>

</div>

@endsection
