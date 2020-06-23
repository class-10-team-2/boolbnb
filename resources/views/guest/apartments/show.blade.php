@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <img class="apt-image" src="{{asset($apartment->img_path)}}" alt="">
    <h1 class="apt-title">{{$apartment->title}}</h1>
  
  </div>
  <div class="col-8">

    <div class="apt-info">
      <span>{{$apartment->rooms}}</span>
      <span>{{$apartment->baths}}</span>
      <span>{{$apartment->beds}}</span>
      <span>{{$apartment->mq}}</span>
    </div>
    <div class="apt-services">
      @foreach ($apartment->services as $service)
        <div class="">
            <p> {{$service->name}}</p>
        </div>
      @endforeach
    </div>
    <h4 class="apt-address">
      <p>{{$apartment->address}}</p>
    </h4>
    <p class="apt-description">
      {{$apartment->description}}
    </p>
  </div>

  <div class="col-4">
    <form action="{{route('guest.apartments.store')}}" method="post">
      @csrf
      @method("POST")
      <div class="form-group">
          <label for="email"></label>
          <input id="email" type="email" name="sender">

          <label for="message"></label>
          <textarea name="text" id="message" cols="30" rows="10"></textarea>

          <input type="text" class="" name='apt_id' value="{{$apartment->id}}" readonly hidden>

          <button type="submit">Invia</button>
      </div>
    </form>
  </div>
  
  
</div>
@endsection