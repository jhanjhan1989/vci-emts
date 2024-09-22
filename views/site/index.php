<?php
$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<div class="container">
    <section class="skills pt-0 pl-0 pr-0 ">
        <?php if (!Yii::$app->user->isGuest) { ?>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => $events,
                        'text' => 'Events',
                        'icon' => 'fas fa-calendar-alt',
                    ]) ?>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => $sports,
                        'text' => 'Sports / Competitions',
                        'icon' => 'fas fa-spa',
                        'theme' => 'success'
                    ]) ?>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => $teams,
                        'text' => 'Teams',
                        'icon' => 'fas fa-user-friends',
                        'theme' => 'warning'
                    ]) ?>
                </div>
            </div>
        <?php } ?>

        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="mb-0">Ranking of Teams / Departments</h5>
                                <span class="mt-0 text-muted small">Shows the overall ranking of competing teams.</span>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group float-right ">
                                    <div class="btn-group mr-2">
                                        <div>
                                            <button type="button" id="btn_events" class="btn btn-default   " data-toggle="dropdown"
                                                data-offset="-52" aria-expanded="false">
                                                Choose Event
                                            </button>
                                            <div id="event_item" class="dropdown-menu pre-scrollable" role="menu"> </div>

                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <div>
                                            <button type="button" id="btn_scheme_main" class="btn btn-default  " data-toggle="dropdown"
                                                data-offset="-52" aria-expanded="false">
                                                <i class="fas fa-palette"></i>
                                            </button>
                                            <div id="scheme_main" class="dropdown-menu pre-scrollable" role="menu"> </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="chart-container">
                            <canvas id="chart" style="position: relative; height:25vh"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Performance Monitoring per Team</h5>
                        <span class="small text-muted">Shows the points acquired by the teams for each sport/ competition.</span>
                    </div>
                    <div class="card-body">
                        <div class="chart-performance-container">
                        <canvas id="chart-performance" style="position: relative; height:25vh"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
<script src="https://unpkg.com/chartjs-plugin-colorschemes"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script> -->
<script type="text/javascript">
    var chart_type_main = 'bar';
    var ctx_main = document.getElementById('chart').getContext('2d');
    var initial_event = 0;
    var config_main = {
        type: chart_type_main,
        data: [],
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                display: true,
                "position": "bottom",
                "align": "start",
            },
            plugins: {
                colorschemes: {
                    scheme: 'tableau.ColorBlind10',
                    override: true,
                },
            },
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                indexAxis: 'y',
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            if (value % 1 === 0) {
                                return value;
                            }
                        }
                    }
                }],

            }
        }
    };

    getThemes();
    getEvents();

    function getEvents() {
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('site/events') ?>",
            type: 'GET',
            data: {
                id: "1"
            },
            success: function(results) {
                var options2 = '';
                var i = 0;
                results.forEach(event => {
                    if (i == 0) {
                        initial_event = event.id;
                        $('#btn_events').text(event.name);
                    }
                    options2 += '<a href="javascript:void(0);" class="dropdown-item event_item " value="' + event.id +
                        '" aria-label="horizontal-bar" id="' + event.id + '">' + event.name + '</a>';
                    i++;
                });
                document.getElementById('event_item').innerHTML = options2;
                getTabulation(initial_event);
                getPerformance(initial_event);
            }
        });
    }

    function getTabulation(id) {
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('site/tabulation') ?>",
            type: 'GET',
            data: {
                id: id
            },
            success: function(results) {
                var data = {
                    labels: results[0].labels,
                    datasets: results[1].datasets,
                };
                config_main.data = data;
                renderThisChart1();
            }
        });
    }


    function getThemes() {
        var colorSchemes2 = Chart.colorschemes;
        var options2 = '';
        Object.keys(colorSchemes2).forEach(function(category) {
            Object.keys(colorSchemes2[category]).forEach(function(scheme) {
                var schemeName2 = category + '.' + scheme;

                if (!schemeName2.includes("brewer")) {
                    options2 += '<a href="javascript:void(0);" class="dropdown-item scheme_main " value="' + schemeName2 +
                        '" aria-label="horizontal-bar" >' + schemeName2 + '</a>'

                }
            });
        });
        document.getElementById('scheme_main').innerHTML = options2;
    }

    function renderThisChart1() {
        window.myChart = new Chart(ctx_main, config_main);
    }

    document.querySelector("#scheme_main").addEventListener("click", (event) => {
        config_main.options.plugins.colorschemes.scheme = event.target.text;
        window.myChart.destroy();
        window.myChart = new Chart(ctx_main, config_main);

    });
    document.querySelector("#event_item").addEventListener("click", (event) => {
        $('#btn_events').text(event.target.text);
        getTabulation(event.target.id);
        getPerformance(event.target.id);
    });
</script>

<script>

var chart_type_perf = 'line';
    var ctx_perf = document.getElementById('chart-performance').getContext('2d');
    var initial_event = 0;
    var config_perf = {
        type: chart_type_perf,
        data: [],
        options: {
            responsive: true,
            maintainAspectRatio: true,
            legend: {
                display: true,
                "position": "bottom",
                "align": "start",
            },
            plugins: {
                colorschemes: {
                    scheme: 'office.Droplet6',
                    override: true,
                },
            },
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                indexAxis: 'y',
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            if (value % 1 === 0) {
                                return value;
                            }
                        }
                    }
                }],

            }
        }
    };


    function getPerformance(id) {
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('site/performance') ?>",
            type: 'GET',
            data: {
                id: id
            },
            success: function(results) {
                var data = {
                    labels: results[0].labels,
                    datasets: results[1].datasets,
                };
                config_perf.data = data;
                renderThisChart2();
            }
        });
    }


    // function getThemes() {
    //     var colorSchemes2 = Chart.colorschemes;
    //     var options2 = '';
    //     Object.keys(colorSchemes2).forEach(function(category) {
    //         Object.keys(colorSchemes2[category]).forEach(function(scheme) {
    //             var schemeName2 = category + '.' + scheme;

    //             if (!schemeName2.includes("brewer")) {
    //                 options2 += '<a href="javascript:void(0);" class="dropdown-item scheme_main " value="' + schemeName2 +
    //                     '" aria-label="horizontal-bar" >' + schemeName2 + '</a>'

    //             }
    //         });
    //     });
    //     document.getElementById('scheme_main').innerHTML = options2;
    // }

    function renderThisChart2() {
        window.perfChart = new Chart(ctx_perf, config_perf);
    }

    // document.querySelector("#scheme_main").addEventListener("click", (event) => {
    //     config_main.options.plugins.colorschemes.scheme = event.target.text;
    //     window.perfChart.destroy();
    //     window.perfChart = new Chart(ctx_main, config_main);

    // });
    
</script>