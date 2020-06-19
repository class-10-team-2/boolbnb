{{-- @extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="" action="{{route('payment.make')}}" method="post">
                @csrf
                @method("POST")
                <select name="">
                    @foreach ($sponsorship_packs as $sponsorship_pack)
                        <option value="{{$sponsorship_pack->id}}">Euro {{$sponsorship_pack->price}} per {{$sponsorship_pack->duration}} ore</option>
                    @endforeach
                </select>
                <div id="dropin-container"></div>
                <button id="submit-button">Request payment method</button>
            </form>
        </div>
    </div>
</div>

<script>
    var button = document.querySelector('#submit-button');
    braintree.dropin.create({
        authorization: "sandbox_zjfh858v_q3x76bj5z6dt98t9",
        container: '#dropin-container'
    }, function (createErr, instance) {
        button.addEventListener('click', function () {
            instance.requestPaymentMethod(function (err, payload) {
                $.get('{{ route('payment.make') }}', {payload}, function (response) {
                    if (response.success) {
                        alert('Payment successfull!');
                    } else {
                        alert('Payment failed');
                    }
                }, 'json');
            });
        });
    });
</script>

@endsection --}}
