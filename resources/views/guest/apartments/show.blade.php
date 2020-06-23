@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <img class="apt-image" src="{{asset($apartment->img_path)}}" alt="">
  </div>
  <div class="col-12">
    <div class="row">
      <h1 class="apt-title">{{$apartment->title}}</h1>
    </div>
    <div class="row">
      <h4 class="apt-address"><a href="http://www.google.com/maps/place/{{$apartment->latitude}},{{$apartment->longitude}}" target="_blank"><i class="fas fa-map-marker-alt"></i> {{$apartment->address}}</a></h4>
    </div>
    <hr>
  </div>
  <div class="row">
    <div class="col-8">
      <div class="apt-info">
        <span><i class="fas fa-door-open"></i> {{($apartment->rooms > 1) ? $apartment->rooms . ' Camere' : '1 Camera'}}</span>
        <span><i class="fas fa-bed"></i> {{($apartment->beds > 1) ? $apartment->beds . ' Letti' : '1 Letto'}}</span>
        <span><i class="fas fa-shower"></i> {{($apartment->baths > 1) ? $apartment->baths . ' Bagni' : '1 Bagno'}}</span>
        <span><i class="fas fa-home"> </i>{{$apartment->mq}}m<sup>2</sup></span>
      </div>
      <div class="apt-services">
        @foreach ($apartment->services as $service)
            @if ($service->name == 'Sauna')
            <span><i class="fas fa-hot-tub"></i> {{$service->name}}</span>
            @elseif ($service->name == 'Piscina')
            <span><i class="fas fa-swimming-pool"></i> {{$service->name}}</span>
            @elseif ($service->name == 'Posto Auto')
            <span><i class="fas fa-car"></i> {{$service->name}}</span>
            @elseif ($service->name == 'Portineria')
            <span><i class="fas fa-concierge-bell"></i> {{$service->name}}</span>
            @elseif ($service->name == 'Vista Mare')
            <span><i class="fas fa-water"></i> {{$service->name}}</span>
            @elseif ($service->name == 'WiFi')
            <span><i class="fas fa-wifi"></i> {{$service->name}}</span>
            @endif
        @endforeach
      </div>
      
      
      <h4>Descrizione</h4>
      <p class="apt-description">
        {{$apartment->description}}
      </p>
    </div>

    <div class="col-4">
      <h4>Contatta l'Host di questo appartamento.</h4>
      <form action="{{route('guest.apartments.store')}}" method="post">
        @csrf
        @method("POST")
        <div class="form-group">
          
          <input id="email" type="email" name="sender" placeholder="La tua email">
        </div> 
        <div class="form-group">
          <textarea name="text" id="message" cols="30" rows="10" placeholder="Il messaggio per l'host"></textarea>
          <input type="text" class="" name='apt_id' value="{{$apartment->id}}" readonly hidden>
        </div>
        <button type="submit" class="btn btn-primary">Invia</button>
      </form>
    </div>
  </div>
</div>
@endsection