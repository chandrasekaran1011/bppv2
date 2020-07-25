@extends('vms.main.layout')

@section('content')
<div class="mydash">
    <link rel="stylesheet" href="{{asset('plugins/chart.js/Chart.min.css')}}">
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

    <div class="row mb-1">
        <div class="col-sm-12 col-md-6 col-lg-3 mb-2 flipInX animated">

            <div class="card mb-3" style="margin-bottom: 0 !important;border: 2px solid  #28a745;background: #ffffff none repeat scroll 0 0;margin: 5px 0;border: 0 solid #e7e7e7;border-radius: 5px;box-shadow: 0px 7px 20px 0px rgba(1, 1, 15, 0.05); ">
                <div class="card-header" style="background-color:  #28a745;color:white;">
                    <i class="fa fa-bar-chart"></i><strong>  Registered Partners</strong>
                </div>
                <div class="card-body" style="text-align: center;">
                    <span style="font-size: 60px;" class="count">15</span> 
                </div>
            </div>

        </div>
        
        <div class="col-sm-12 col-md-6 col-lg-3 mb-2 flipInX animated">

            <div class="card mb-3" style="margin-bottom: 0 !important;border: 2px solid #211dd4;background: #ffffff none repeat scroll 0 0;margin: 5px 0;border: 0 solid #e7e7e7;border-radius: 5px;box-shadow: 0px 7px 20px 0px rgba(1, 1, 15, 0.05); ">
                <div class="card-header" style="background-color: #211dd4;color:white;">
                    <i class="fa fa-bar-chart"></i><strong>  Pending Approval</strong>
                </div>
                <div class="card-body" style="text-align: center;">
                    <span style="font-size: 60px;" class="count">3</span> 
                </div>
            </div>

        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-2 flipInX animated">

            <div class="card mb-3" style="margin-bottom: 0 !important;border: 2px solid #ffc107;background: #ffffff none repeat scroll 0 0;margin: 5px 0;border: 0 solid #e7e7e7;border-radius: 5px;box-shadow: 0px 7px 20px 0px rgba(1, 1, 15, 0.05); ">
                <div class="card-header" style="background-color: #ffc107;color:white;">
                    <i class="fa fa-bar-chart"></i><strong>Renewal Due</strong>
                </div>
                <div class="card-body" style="text-align: center;">
                    <span style="font-size: 60px;" class="count">8</span> 
                </div>
            </div>

        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-2 flipInX animated">

            <div class="card mb-3" style="margin-bottom: 0 !important;border: 2px solid #000000;background: #ffffff none repeat scroll 0 0;margin: 5px 0;border: 0 solid #e7e7e7;border-radius: 5px;box-shadow: 0px 7px 20px 0px rgba(1, 1, 15, 0.05); ">
                <div class="card-header" style="background-color: #000000;color:white;">
                    <i class="fa fa-bar-chart"></i><strong> Blacklist Partner</strong>
                </div>
                <div class="card-body" style="text-align: center;">
                    <span style="font-size: 60px;" class="count">2</span> 
                </div>
            </div>

        </div>

    </div>

    <div class="row mt-3">
        <div class="col">
            
            <div class="card mb-3 flipInX animated" style="margin-bottom: 0 !important;border: 2px solid #6610f2;background: #ffffff none repeat scroll 0 0;margin: 5px 0;border: 0 solid #e7e7e7;border-radius: 5px;box-shadow: 0px 7px 20px 0px rgba(1, 1, 15, 0.05); ">
                <div class="card-header" style="background-color:#6610f2;color:white;font-weight:bold">
                    <i class="fas fa-chart-pie"></i>&nbsp;Partner Types
                </div>
                <div class="card-body" style="text-align: center;">
                    <canvas id="chart-area"   class="chartjs-render-monitor"></canvas>
                </div>
            </div>

            
            <script>
                $(document).ready(function () {
                        var randomScalingFactor = function() {
                            return Math.round(Math.random() * 100);
                        };

                        var config = {
                            type: 'pie',
                            data: {
                                datasets: [{
                                    data: [
                                        100,15,50,10,7
                                    ],
                                    backgroundColor: ['#003f5c','#58508d','#bc5090','#ff6361','#ffa600'
                                    ],
                                    label: 'Dataset 1'
                                }],
                                labels: [
                                    'Sub-contractor',
                                    'Supplier',
                                    'JV partner',
                                    'Private Client',
                                    'Public Client'
                                ]
                            },
                            options: {
                                responsive: true,
                                legend:{'position':'right'}
                            }
                        };

                        window.onload = function() {
                            var ctx = document.getElementById('chart-area').getContext('2d');
                            window.myPie = new Chart(ctx, config);
                        };

                });
            </script>

        </div>
        <div class="col">
            <div class="card mb-3 flipInX h-100 animated delay-3s" style="margin-bottom: 0 !important;border: 2px solid #6610f2;background: #ffffff none repeat scroll 0 0;margin: 5px 0;border: 0 solid #e7e7e7;border-radius: 5px;box-shadow: 0px 7px 20px 0px rgba(1, 1, 15, 0.05); ">
                <div class="card-header" style="background-color:#6610f2;color:white;font-weight:bold">
                    <i class="far fa-calendar-alt"></i>&nbsp;Upcoming CDO
                </div>
                <div class="card-body p-2" style="text-align: center;">
                    <div class="card mb-2 animated flash infinite delay-2s">
                        <div class="card-header">30th April - Afcons Ltd </div>
                        
                    </div>
                    <div class="card mb-2">
                        <div class="card-header">7th May-  Tata Steel </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header"> 11th May - Maha Metro </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
                        
            <div class="card mb-3 flipInX animated h-100" style="margin-bottom: 0 !important;border: 2px solid #6610f2;background: #ffffff none repeat scroll 0 0;margin: 5px 0;border: 0 solid #e7e7e7;border-radius: 5px;box-shadow: 0px 7px 20px 0px rgba(1, 1, 15, 0.05); ">
                <div class="card-header" style="background-color:#6610f2;color:white;font-weight:bold">
                    <i class="fas fa-chart-pie"></i>&nbsp;Registration Monthly
                </div>
                <div class="card-body" style="text-align: center;">
                    <canvas id="myChart"   class="chartjs-render-monitor"></canvas>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    var ctx = document.getElementById("myChart");
                    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["JAN","FEB","MAR", "APR"],
                        datasets: [{
                        label: '# of Registrations',
                        data: [12, 19, 10, 7],
                        backgroundColor: [
                            'rgba(255, 99, 132)',
                            'rgba(54, 162, 235)',
                            'rgba(255, 206, 86)',
                            'rgba(75, 192, 192)',
  
                            
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',

                        ],
                        borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: false,
                        scales: {
                         xAxes: [{
                                    barPercentage: 0.5,
                                    gridLines: {
                                        display: !1
                                    },
                                    ticks: {
                                        maxTicksLimit: 6
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        min: 0,
                                        max: 30,
                                        stepSize:10 },
                                    gridLines: {
                                        display: !0
                                    }
                                }]
                        }
                    }
                    });
                });
            </script>

        </div>

    </div>

    <script>
        $(".count").each(function () {
            $(this).prop("Counter",0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 3000,
                    easing: "swing",
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
        });
    </script>


</div>
    

@endsection

