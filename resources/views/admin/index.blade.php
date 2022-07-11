@extends('layouts/admin/app')

@section('content')
<div class="container-fluid px-3">

    <div class="d-sm-flex flex-row align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-gray-800">{{__('charts.charts_title')}}</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#reportModal">{{__('charts.change_date_range')}}</button>
        <!-- Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">{{__('charts.time_range')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="fromDate">{{__('charts.from')}}</label>
                        <input type="date" class="form-control" max="{{ date('Y-m-d', strtotime('today')) }}" id="dateRangeFromDate">

                        <label for="toDate">{{__('charts.till')}}</label>
                        <input type="date" class="form-control" max="{{ date('Y-m-d', strtotime('today')) }}" id="dateRangeToDate">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('charts.close')}}</button>
                        <button type="button" onclick="changeDateRange()" class="btn btn-primary" data-dismiss="modal">{{__('charts.execute')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-row">
        <h5 id="reportDate">{{__('charts.report_date_past_month')}}</h5>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{__('charts.amount_chatmessages')}}</div>
                        <div id="chatmessages" class="h5 mb-0 font-weight-bold text-gray-800">{{__('charts.loading')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{__('charts.amount_new_accounts')}}</div>
                        <div id="newAccounts" class="h5 mb-0 font-weight-bold text-gray-800">{{__('charts.loading')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-12 mb-2">
        <a href=# id="activeUserLink">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{__('charts.active_user')}}</div>
                            <div id="activeUser" class="h5 mb-0 font-weight-bold text-gray-800">{{__('charts.loading')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class='row mb-3'>

    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4 h-100">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{__('charts.amount_total_events')}}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="events" height="100px"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4 h-100">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{__('charts.shared_events')}}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="shares" height="220px"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{__('charts.amount_zero_participants')}}</div>
                        <div id="zeroParticipants" class="h5 mb-0 font-weight-bold text-gray-800">{{__('charts.loading')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{__('charts.amount_average_participants')}}</div>
                        <div id="averageParticipants" class="h5 mb-0 font-weight-bold text-gray-800">{{__('charts.loading')}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-12 mb-2">
        <a href=# id="mostParticipantsLink">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{__('charts.most_active_event')}}</div>
                            <div id="mostParticipants" class="h5 mb-0 font-weight-bold text-gray-800">{{__('charts.loading')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>

<div class='row mb-3'>
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4 h-100">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{__('charts.event_categories')}}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="categories" height="250px"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4 h-100">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{__('charts.event_heatmap')}}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div id="map" style="min-height: 400px" class="h-100 rounded"></div>
            </div>
        </div>
    </div>
</div>

<script>
    Chart.plugins.register({
        afterDraw: function(chart) {
            if (chart.data.datasets[0].data.length === 0) {
                // No data is present
                var ctx = chart.chart.ctx;
                var width = chart.chart.width;
                var height = chart.chart.height
                chart.clear();

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = "32px Sans-Serif";
                ctx.fillText('{{__('charts.no_data')}}', width / 2, height / 2);
                ctx.restore();
            }
        }
    });

    //Manually update cards on page load
    updateChatmessagesSend();
    updateAccountsCreated();
    updateMostActiveAccount();
    updateZeroParticipants();
    updateMostParticipants();
    updateAverageParticipants();

    //EventChart
    var eventChart = new Chart(document.getElementById('events'), {
        type: 'line',
        data: getEventData(),
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        autoSkip: true,
                    }
                }],
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: false,
                        minUnit: 'day',
                        tooltipFormat: 'lll',
                        round: false,
                    },
                }]
            }
        }
    });

    //ShareChart
    var shareChart = new Chart(document.getElementById("shares"), {
        type: 'doughnut',
        data: getShareData(),
        options: {
            maintainAspectRatio: true
        }
    });


    //CategoriesChart
    var categoriesChart = new Chart(document.getElementById("categories"), {
        type: 'doughnut',
        data: getCategoryData(),
        options: {
            maintainAspectRatio: true
        }
    });

    function changeDateRange() {
        let fromDate = document.getElementById("dateRangeFromDate").value;
        let toDate = document.getElementById("dateRangeToDate").value;
        updateCharts(fromDate, toDate);
    }

    function updateCharts(fromDate, toDate) {
        updateDateString(fromDate, toDate);
        updateChatmessagesSend(fromDate, toDate);
        updateAccountsCreated(fromDate, toDate);
        updateMostActiveAccount(fromDate, toDate);
        updateZeroParticipants(fromDate, toDate);
        updateMostParticipants(fromDate, toDate)
        updateAverageParticipants(fromDate, toDate)

        updateEventChart(fromDate, toDate);
        updateShareChart(fromDate, toDate);
        updateCategoryChart(fromDate, toDate);
        updateHeatmap(fromDate, toDate);
    }

    function updateDateString(fromDate, toDate) {
        $.ajax({
            url: "{{ route('admin_charts_update_date_string') }}",
            method: 'POST',
            async: true,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById("reportDate").innerHTML = data;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function updateChatmessagesSend(fromDate, toDate) {
        document.getElementById("chatmessages").innerHTML = "{{__('charts.loading')}}";
        $.ajax({
            url: "{{ route('admin_charts_chatmessages') }}",
            method: 'POST',
            async: true,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById("chatmessages").innerHTML = data.messageData.messageCount;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                    document.getElementById("chatmessages").innerHTML = '{{__('charts.no_data')}}';
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function updateAccountsCreated(fromDate, toDate) {
        document.getElementById("newAccounts").innerHTML = "{{__('charts.loading')}}";

        $.ajax({
            url: "{{ route('admin_charts_accounts_created') }}",
            method: 'POST',
            async: true,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById("newAccounts").innerHTML = data.accountData.accountCount;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                    document.getElementById("newAccounts").innerHTML = '{{__('charts.no_data')}}';
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function updateMostActiveAccount(fromDate, toDate) {
        document.getElementById("activeUser").innerHTML = "{{__('charts.loading')}}";

        $.ajax({
            url: "{{ route('admin_charts_most_active_user') }}",
            method: 'POST',
            async: true,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    let name = data[0].firstName
                    if (data[0].middleName != null) {
                        name = name + ' ' + data[0].middleName + ' '
                    } else {
                        name = name + ' ';
                    }
                    name = name + data[0].lastName;

                    document.getElementById("activeUser").innerHTML = name;
                    document.getElementById("activeUserLink").href = '{{url('/admin/accounts/')}}' + '/' + data[0].id;
                } else {
                    document.getElementById("activeUser").innerHTML = '{{__('charts.no_data')}}';
                    document.getElementById("activeUserLink").href = '#';
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function updateZeroParticipants(fromDate, toDate) {
        document.getElementById("zeroParticipants").innerHTML = "{{__('charts.loading')}}";
        $.ajax({
            url: "{{ route('admin_charts_zero_participants') }}",
            method: 'POST',
            async: true,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById("zeroParticipants").innerHTML = data.zeroParticipantEventData.zeroParticipantCount;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                document.getElementById("zeroParticipants").innerHTML = '{{_('charts.no_data')}}';
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function updateMostParticipants(fromDate, toDate) {
        document.getElementById("mostParticipants").innerHTML = "{{__('charts.loading')}}";
        $.ajax({
            url: "{{ route('admin_charts_most_participants') }}",
            method: 'POST',
            async: true,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById("mostParticipants").innerHTML = data.mostParticipantEventData.eventName + ' | ' + data.mostParticipantEventData.amount + ' {{__('charts.participants')}}';
                document.getElementById("mostParticipantsLink").href = '{{url('/events/')}}' + '/' + data.mostParticipantEventData.id;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                document.getElementById("mostParticipants").innerHTML = '{{__('charts.no_data')}}';
                document.getElementById("mostParticipantsLink").href = '#';
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function updateAverageParticipants(fromDate, toDate) {
        document.getElementById("averageParticipants").innerHTML = "{{__('charts.loading')}}";
        $.ajax({
            url: "{{ route('admin_charts_average_participants') }}",
            method: 'POST',
            async: true,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById("averageParticipants").innerHTML = data.averageParticipantEventData.averageParticipantCount;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                document.getElementById("averageParticipants").innerHTML = '{{__('charts.no_data')}}';
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function updateEventChart(fromDate, toDate) {
        eventChart.data = getEventData(fromDate, toDate);
        eventChart.update();
    }

    function updateShareChart(fromDate, toDate) {
        shareChart.data = getShareData(fromDate, toDate);
        shareChart.update();
    };

    function updateCategoryChart(fromDate, toDate) {
        categoriesChart.data = getCategoryData(fromDate, toDate);
        categoriesChart.update();
    }

    function getEventData(fromDate, toDate) {
        var plotLabels = [];
        var plotData = [];

        $.ajax({
            url: "{{ route('admin_charts_events') }}",
            method: 'POST',
            async: false,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                data.forEach(function(item) {
                    plotData.push({
                        t: Date.parse(item.date),
                        y: item.totalEvents
                    });
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

        return {
            labels: plotLabels,
            datasets: [{
                data: plotData,
                borderColor: `rgba(25, 93, 230, 1)`
            }]
        };
    }

    function getShareData(fromDate, toDate) {
        let plotLabels = [];
        let plotData = [];

        $.ajax({
            url: "{{ route('admin_charts_shares') }}",
            method: 'POST',
            async: false,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                data.shareData.forEach(function(item) {
                    plotLabels.push(item.platform);
                    plotData.push(item.shareCount);
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

        var haha = {
            labels: plotLabels,
            datasets: [{
                backgroundColor: getColors(plotLabels.length),
                data: plotData
            }]
        };

        return haha;
    }

    function getCategoryData(fromDate, toDate) {
        let plotLabels = [];
        let plotData = [];

        $.ajax({
            url: "{{ route('admin_charts_categories') }}",
            method: 'POST',
            async: false,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                data.categoryData.forEach(function(item) {
                    plotLabels.push(item.category);
                    plotData.push(item.count);
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

        return {
            labels: plotLabels,
            datasets: [{
                backgroundColor: getColors(plotLabels.length),
                data: plotData
            }]
        };
    }

    function getColors(amount) {
        let colors = [];

        let colorstep = 360 / amount;
        let i;
        for (i = 0; i < amount; i++) {
            colors.push('hsl(' + Math.floor(colorstep * i) + ', 68%, 50%)');
        }
        return colors;
    }

    var map, heatmap;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6.7,
            center: {
                lat: 52,
                lng: 5.8
            }
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
            data: getPoints(null, null),
            map: map,
            opacity: 0.5,
            radius: 20
        });
    }

    // Heatmap data
    function getPoints(fromDate, toDate) {
        var plotLatLng = [];

        $.ajax({
            url: "{{ route('admin_charts_locations') }}",
            method: 'POST',
            async: false,
            data: {
                fromDate: fromDate,
                toDate: toDate,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                data.forEach(function(item) {
                    plotLatLng.push(new google.maps.LatLng(item.lat, item.lng));
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
        return plotLatLng;
    }

    function updateHeatmap(fromDate, toDate) {
        heatmap.setData(getPoints(fromDate, toDate));
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&libraries=visualization&callback=initMap" async defer></script>
@endsection