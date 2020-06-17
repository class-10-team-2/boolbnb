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

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form class="" action="{{route('payment.make')}}" method="post">
                        @csrf
                        @method('POST')
                        <select name="">
                            @foreach ($sponsorship_packs as $sponsorship_pack)
                                <option value="{{$sponsorship_pack->id}}">Euro {{$sponsorship_pack->price}} per {{$sponsorship_pack->duration}} ore</option>
                            @endforeach
                        </select>
                        <input type="submit" name="" value="Vai alla pagina di pagamento">
                    </form>
                </div>
            </div>
        </div>



</div>

@endsection
