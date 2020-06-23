@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div>
    <img class="apt-image" src="" alt="">
    <h1 class="apt-title"></h1>
  
  </div>
  <div class="col-8">

    <div class="apt-info">

    </div>
    <h4 class="apt-address">
  
    </h4>
    <p class="apt-description">
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