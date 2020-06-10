@extends('layouts.app');
@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <form action="{{route('user.apartments.store')}}" method="POST" enctype="multipart/form-data">
        @method("POST")
        @csrf
        <div class="form-group">
          <label for="title">Nome appartamento</label>
          <input type="text" class="form-control" id="title" name="title">
            @error('title')
              <small class="form-text">Errore</small>
            @enderror
        </div>
        <div class="form-group">
          <label for="rooms">Numero di camere</label>
          <input type="number" min="0" max="10" id="rooms" name="rooms">
          
        </div>
        <div class="form-group">
          <label for="beds">Numero di letti</label>
          <input type="number" min="0" max="20" id="beds" name="beds">
        </div>
        <div class="form-group">
          <label for="baths">Numero di bagni</label>
          <input type="number" min="0" max="10" id="baths" name="baths">
        </div>
        <div class="form-group">
          <label for="mq">Metri quadri</label>
          <input type="number" class="form-control" id="mq" name="mq">
          {{-- togliere frecce --}}
        </div>
        <div class="form-group">
          <label for="address">Indirizzo</label>
          <input type="text" class="form-control" id="address" name="address">
        </div>
        <div class="form-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="img_path" name="img_path">
            <label class="custom-file-label" for="img_path">Carica una foto</label>
          </div>
        </div>
      </form>
      
    </div>
  </div>
</div>

@endsection