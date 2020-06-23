@extends('layouts.app')
@section('content')
<div class="container">
  <h3>I tuoi messaggi per <strong>{{$apartment->title}}</strong></h3>
  {{ $messages->links() }}
  @foreach ($messages  as $message)
  <div class="row">
    <div class="col-3 date">{{Carbon\Carbon::parse($message->created_at)->format('d-m-Y | h:i')}}</div>
    <div class="col-3 sender">{{$message->sender}}</div>
    <div class="col-6 text">{{$message->text}}</div>
  </div>
  <hr>
  @endforeach
  {{ $messages->links() }}
</div>
@endsection