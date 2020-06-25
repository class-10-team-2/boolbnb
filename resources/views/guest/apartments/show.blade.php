@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row row-img">
    <img class="apt-image" src="{{asset('storage/' . $apartment->img_path)}}" alt="{{$apartment->title}}">
  </div>
  <div class="col-12">
    <div class="row container-margin">
      <h1 class="apt-title">{{$apartment->title}}</h1>
    </div>
    <div class="row container-margin">
      <h4 class="apt-address"><a href="http://www.google.com/maps/place/{{$apartment->latitude}},{{$apartment->longitude}}" target="_blank"><i class="fas fa-map-marker-alt"></i> {{$apartment->address}}</a></h4>
    </div>
    <hr>
  </div>
  <div class="row container-margin">
    <div class="col-8">
      <div class="apt-info">
        <span><i class="fas fa-door-open"></i> {{($apartment->rooms > 1) ? $apartment->rooms . ' Camere' : '1 Camera'}}</span>
        <span><i class="fas fa-bed"></i> {{($apartment->beds > 1) ? $apartment->beds . ' Posti letto' : '1 Posto letto'}}</span>
        <span><i class="fas fa-shower"></i> {{($apartment->baths > 1) ? $apartment->baths . ' Bagni' : '1 Bagno'}}</span>
        <span><i class="fas fa-home"> </i>{{$apartment->mq}}m<sup>2</sup></span>
      </div>



      <h4>Descrizione</h4>
      <p class="apt-description">
        {{$apartment->description}}
      </p>

      <h4>Servizi</h4>

      <div class="apt-services flex-info">

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
        <div class="map">
          <iframe
            width="600"
            height="450"
            frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDDdTa4Rc01xKmqdHC8SOVLoGyJ9mBAYmE&q={{$apartment->address}}&center={{$apartment->latitude}},{{$apartment->longitude}}">
          </iframe>
        </div>
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
