@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    <div class="col-12">
        <div class="card" style="width: 18rem;">
            {{-- immagine caricata come file --}}
            {{-- <img src="{{asset('storage/' . $apartment->img_path)}}" class="card-img-top" alt="{{$apartment->title}}"> --}}
            {{-- immagine caricata con la factory --}}
            <img src="{{asset($apartment->img_path)}}" class="card-img-top" alt="{{$apartment->title}}">
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
</div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {{-- <form class="" action="{{ route('user.apartments.store_sponsoship') }}" method="post"> --}}
                {{-- <form class="" action="/user/store_sponsoship" method="post"> --}}
                    {{-- @csrf
                    @method('POST') --}}

                    <input type="hidden" name="id" value="{{$apartment->id}}">


                    @foreach ($sponsorship_packs as $sponsorship_pack)
                        <div class="form-check">
                            <input type="hidden" name="duration" value="{{$sponsorship_pack->duration}}">
                            <input class="form-check-input" type="radio" name="sponsorship" value="{{$sponsorship_pack->id}}">
                            <label>{{$sponsorship_pack->price}} Euro per {{$sponsorship_pack->duration}} ore</label>
                        </div>
                    @endforeach

                    <div id="dropin-container"></div>
                    <button type="submit" id="submit-button">Conferma metodo di pagamento</button>
                {{-- </form> --}}
            </div>
        </div>

    <script>
        var button = document.querySelector('#submit-button');
        braintree.dropin.create({
            authorization: "sandbox_zjfh858v_q3x76bj5z6dt98t9",
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
                            alert('Payment failed');
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
