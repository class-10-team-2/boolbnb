@extends('layouts.app')
@section('content')

    <div class="">
        <canvas id="chart_mensile"></canvas>

    </div>
    <input type="text" name="apt_id" value="{{$apartment->id}}" hidden>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">

</script>

<script>
$(document).ready(function() {

    getStats();

    


    function getStats() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/json-stats',
                        type: 'get',
                        // dataType: "json",
                        data: {
                            apt_id: $('input[name=apt_id]').val(),
                        },
                        success: function (response) {
                            
                            makeChart(response); 
                            
                        },
                        error: function (response) {
                            console.log('Error:', response);
                        }
                    });
    }

    function makeChart(current_year_sessions){
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
                data: current_year_sessions
            }]
    },

    

    // Configuration options go here
    options: {}
    });
    }

    
});

</script>
