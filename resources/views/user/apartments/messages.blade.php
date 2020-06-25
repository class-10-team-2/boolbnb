@extends('layouts.app')
@section('content')
<div class="container">
    <div class="title-margin">
          <h3>I tuoi messaggi per <strong>{{$apartment->title}}</strong></h3>

    </div>

    <table class="table">
        <thead class="thead-dark">
            <tr>

                <th scope="col">Ora</th>
                <th scope="col">Mittente</th>
                <th scope="col">Testo</th>
            </tr>
        </thead>
        <tbody>
            {{ $messages->links() }}
            @foreach ($messages  as $message)
                <tr>
                    <td>{{Carbon\Carbon::parse($message->created_at)->addHour(2)->format('d-m-Y | H:i')}}</td>
                    <td> <a href="mailto:{{$message->sender}}">{{$message->sender}}</td>
                    <td>{{$message->text}}</td>

                </tr>

            @endforeach
        </tbody>

    </table>

  {{ $messages->links() }}


</div>
@endsection
