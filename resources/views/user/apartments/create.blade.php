@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <form action="{{route('user.apartments.store')}}" method="POST" enctype="multipart/form-data">
        @method("POST")
        @csrf
        <div class="form-group">
          <label for="title">Nome appartamento</label>
          <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
            @error('title')
              <small class="form-text">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{old('description')}}</textarea>
          </div>
        <div class="form-group">
          <label for="rooms">Numero di camere</label>
          <input type="number" min="0" max="10" id="rooms" name="rooms" value="{{old('rooms')}}">
          @error('rooms')
            <small class="form-text">{{$message}}</small>
          @enderror

        </div>
        <div class="form-group">
          <label for="beds">Numero di letti</label>
          <input type="number" min="0" max="20" id="beds" name="beds" value="{{old('beds')}}">
          @error('beds')
            <small class="form-text">{{$message}}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="baths">Numero di bagni</label>
          <input type="number" min="0" max="10" id="baths" name="baths" value="{{old('baths')}}">
          @error('baths')
            <small class="form-text">{{$message}}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="mq">Metri quadri</label>
          <input type="number" class="form-control" id="mq" name="mq" value="{{old('mq')}}">
          {{-- togliere frecce --}}
          @error('mq')
            <small class="form-text">{{$message}}</small>
          @enderror
        </div>
        <div class="form-group">
          <label for="address-input">Indirizzo</label>
          <input type="text" class="form-control address-input" id="address-input" name="address" value="{{old('address')}}">
          <input type="text" class="form-control lat-input" name="latitude" value="{{old('latitude')}}">
          <input type="text" class="form-control lng-input" name="longitude" value="{{old('longitude')}}">

          @error('address')
            <small class="form-text">{{$message}}</small>
          @enderror
        </div>
        <div class="form-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="img_path" name="img_path" value="{{old('img_path')}}">
            <label class="custom-file-label" for="img_path">Carica una foto</label>
            @error('img_path')
              <small class="form-text">{{$message}}</small>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <h3>Seleziona i servizi disponibili</h3>
          @foreach ($services as $service)
            <div class="form-check form-check-inline">
              <input type="checkbox" id="service-{{$service->id}}" name="services[]" value="{{$service->id}}"
              {{(is_array(old('services')) && in_array($service->id, old('services'))) ? 'checked' : ''}}>

              <label for="service-{{$service->id}}">{{$service->name}}</label>
            </div>
          @endforeach
          <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Inserisci">
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection
