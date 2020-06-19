@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form>
            @method('POST')
            @csrf

            <div class="form-group">
                <input id="search-input" type="search" class="address-input" name="address" placeholder="Dove vuoi andare?" />
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="radius">Raggio di ricerca</label>
                    <input id="radius" class="form-control" type="number" name="radius" min="1" max="50" value="20">
                </div>
                <div class="col">
                    <label for="rooms">Minimo di stanze</label>
                    <input id="rooms" class="form-control" type="number" name="rooms" min="0" max="10" value="1">
                </div>
                <div class="col">
                    <label for="beds">Minimo posti letto</label>
                    <input id="beds" class="form-control" type="number" name="beds" min="1" max="20" value="1">
                </div>
            </div>

            <div class="form-group">
                @foreach ($services as $service)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="services[]" type="checkbox" id="{{$service->name}}" value="{{$service->id}}">
                        <label class="form-check-label" for="{{$service->name}}">{{$service->name}}</label>
                    </div>
                @endforeach
            </div>

            <input id="latitude" type="hidden" class="lat-input" name="lat">
            <input id="longitude" type="hidden" class="lng-input" name="lng">

            <input id="search-button" class="btn btn-primary" type="submit" name="" value="Cerca">

        </form>

        {{-- JAVASCRIPT --}}
        <script type="text/javascript">

            $(document).on('click', '#search-button', function () {
                $('#search-input').val('');

                sendInputValues();

                getSearchResults();
            });

            function sendInputValues() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    }
                });

                $.ajax({
                    url: 'guest/apartment/search',
                    type: 'post',
                    // async:false,
                    // dataType: "json",
                    data: {
                        radius: $('#radius'),
                        minRooms: $('#rooms'),
                        minBeds: $('#beds'),
                        lat: $('#latitude'),
                        lng: $('#longitude'),

                    },
                    success: function (data) {
                        console.log('data: ',  data);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        </script>
        {{-- <div class="col-12" id="instantsearch">
            <input type="text" id="searchbox" name="" value="">
            <input type="text" id="lat" name="" value="">
            <input type="text" id="lng" name="" value="">
            <input type="text" id="address" name="" value="">
        </div>

        <div id="hits">

        </div> --}}
    </div>
</div>


@endsection
