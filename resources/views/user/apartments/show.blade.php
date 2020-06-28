@extends('layouts.app')
@section('content')
<div class="container-fluid">
  @if ($apartment->id <= 13)
  <div class="row row-img">
    <img class="apt-image" src="{{$apartment->img_path}}" alt="{{$apartment->title}}">
  </div> 
  @else
  <div class="row row-img">
    <img class="apt-image" src="{{asset('storage/' . $apartment->img_path)}}" alt="{{$apartment->title}}">
  </div>    
  @endif
    <div class="col-12 flex-dir">
        <div class="">
            <div class="row margin-zero ">
              <h1 class="apt-title">{{$apartment->title}}</h1>
            </div>
            <div class="row margin-zero">
              <h4 class="apt-address"><a href="http://www.google.com/maps/place/{{$apartment->latitude}},{{$apartment->longitude}}" target="_blank"><i class="fas fa-map-marker-alt"></i> {{$apartment->address}}</a></h4>
            </div>
            <div class="stats-mess row">
                <a href="{{route('user.apartments.stats', $apartment->id)}}" class="btn btn-primary btn-space">Statistiche</a>
                <a href="{{route('user.apartments.messages', $apartment->id)}}" class="btn btn-primary btn-space">Messaggi</a>

            </div>

        </div>






    </div>
    <hr>
    <div class="row container-margin">
        <div class="col-md-6">
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
          <div class="controls">
              <a href="{{route('user.apartments.edit', $apartment->id)}}" class="btn btn-edit btn-primary">Modifica</a>
              <form class="" action="{{route('user.apartments.destroy', $apartment->id)}}" method="post">
                  @method('DELETE')
                  @csrf
                  <input class="btn btn-danger" type="submit" name="" value="Elimina">
              </form>
          </div>

        </div>


        <div class="col-md-3 offset-md-2 payment">
            {{-- <form class="" action="{{ route('user.apartments.store_sponsoship') }}" method="post"> --}}
            {{-- <form class="" action="/user/store_sponsoship" method="post"> --}}
                {{-- @csrf
                @method('POST') --}}


                <input type="hidden" name="id" value="{{$apartment->id}}">


                <div class="options">
                    <h4><i class="fas fa-chart-line"></i> Metti in evidenza il tuo appartamento</h4>
                    <p>Scegli il piano di sponsorizzazione piu adatto alle tue esigenze. Otterrai maggiore visibiltà nei risultati di ricerca per il periodo in cui hai attivato la sponsorizzazione.</p>
                    @foreach ($sponsorship_packs as $sponsorship_pack)
                        <div class="form-check">
                            @if ($sponsorship_pack->duration == 24)
                                <input type="hidden" name="duration" value="{{$sponsorship_pack->duration}}">
                                <input class="form-check-input" type="radio" name="sponsorship" value="{{$sponsorship_pack->id}}" checked>
                                <label>{{$sponsorship_pack->price}}€ per {{$sponsorship_pack->duration / 24}} giorno</label>
                            @else
                                <input type="hidden" name="duration" value="{{$sponsorship_pack->duration}}">
                                <input class="form-check-input" type="radio" name="sponsorship" value="{{$sponsorship_pack->id}}">
                                <label>{{$sponsorship_pack->price}}€ per {{$sponsorship_pack->duration / 24}} giorni</label>
                            @endif
                        </div>
                    @endforeach
                    <button class="go-to-payment btn btn-primary">Sponsorizza</button>
                </div>
                <div class="box-paypal d-none">
                    <div class="paypal">

                        <div id="dropin-container"></div>
                        <button type="submit" id="submit-button">Conferma pagamento</button>
                        <button class="back-button">Indietro</button>

                    </div>
                </div>

            {{-- </form> --}}
        </div>
    </div>
</div>
    <script>
        //======= visualizzazione box pagamento
        $('button.go-to-payment').on('click', function () {

            $('.box-paypal').removeClass("d-none");

        });
        $('button.back-button').on('click', function () {

           $('.box-paypal').addClass("d-none");

       });
        //=======
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            //===============!!!!!!!!! TOKEN !!!!!!!!!==================
            authorization: "sandbox_zjfh858v_q3x76bj5z6dt98t9",
            //===============!!!!!!!!! BRAINTREE !!!!!!!!!==================

            container: '#dropin-container'
        }, function (createErr, instance) {
            button.addEventListener('click', function () {
                // event.preventDefault()
            // button.click(function(event) {
            //     event.preventDefault();
                instance.requestPaymentMethod(function (err, payload) {
                    $.get('{{ route('payment.make') }}', {payload}, function (response) {
                        if (response.success) {
                            alert('Payment successfull!');

                            var radioValue = $("input[name='sponsorship']:checked").val();
                            // console.log('radio value: ' + radioValue);
                            var apartmentId = $("input[name='id']").val();
                            // console.log('apartment id: ' + apartmentId);
                            // var duration = $("input[name='duration']:checked").val();

                            // console.log(duration);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                                }
                            });

                            $.ajax({
                                url: '/user/store_sponsoship',
                                type: 'post',
                                // async:false,
                                // dataType: "json",
                                data: {

                                    radioVal: radioValue,
                                    apartId: apartmentId
                                    // duration: duration
                                },
                                success: function (data) {
                                    console.log('data: ',  data);
                                },
                                error: function (data) {
                                    console.log('Error:', data);

                                }
                            });

                        } else {
                            alert('Pagamento fallito');
                        }
                    }, 'json');
                });


                // $.ajax({
                //     url: '/store_sponsoship',
                //     method: 'POST',
                //     // async:false,
                //     dataType: "json",
                //     data: {
                //
                //         radioVal: radioValue,
                //         apartmentId: apartmentId
                //     },
                //     success: function (data) {
                //         console.log('data: ',  data);
                //     },
                //     error: function (data) {
                //         console.log('Error:', data);
                //
                //     }
                // });
            });
        });
    </script>

</div>

@endsection

{{-- @if (isset($data))

    var_dump($data);

@endif --}}
