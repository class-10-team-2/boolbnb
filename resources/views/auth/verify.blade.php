@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica indirizzo email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un nuovo link di verifica è stato inviato alla tua email.') }}
                        </div>
                    @endif

                    {{ __('Prima di procedere, usa il link di verica inviato alla tua email.') }}
                    {{ __('Se non hai ricevuto nessuna email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('clicca qui per richiederne una nuova.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
