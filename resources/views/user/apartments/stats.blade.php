@extends('layouts.app')
@section('content')

    <div class="">
        <canvas id="chart_mensile"></canvas>

    </div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">

</script>

<script>
$(document).ready(function() {

    var ctx = $('#chart_mensile');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August', 'September', 'October','November','December'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, {{$sessions->count()}}, 45, 98, 22, 14, 65, 43]
        }]
    },

    // Configuration options go here
    options: {}
});
});


</script>
