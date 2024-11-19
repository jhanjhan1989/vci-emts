<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<style>
    .text-bronze{
        color:#CD7F32; 
    }

</style>
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
            <div class="col-8">

                <div class="card">
                    <div class="card-header  ">

                        <div class="card-title">
                            <h5 class="mb-0">Ranking of Teams / Departments</h5>
                            <span class="mt-0 text-muted small">Shows the overall ranking of competing teams.</span>
                        </div>

                        <div class="card-tools">
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                <i class="fas fa-sync-alt"></i>
                            </button> -->
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>

                    </div>
                    <div class="card-body  ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="h3  " style="height: 30px;">
                                    <marquee class="text-info" direction="left" height="100px" id="marquee">
                                    </marquee>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group float-right  pt-0">


                                    <div class="btn-group mr-2">
                                        <div>
                                            <button type="button" id="btn_events" class="btn btn-default rounded-pill   " data-toggle="dropdown"
                                                data-offset="-52" aria-expanded="false">
                                                Choose Event
                                            </button>
                                            <div id="event_item" class="dropdown-menu pre-scrollable" role="menu"> </div>

                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <div>
                                            <button type="button" id="btn_scheme_main" class="btn   btn-default rounded-pill " data-toggle="dropdown"
                                                data-offset="-52" aria-expanded="false">
                                                <i class="fas fa-palette"></i>
                                            </button>
                                            <div id="scheme_main" class="dropdown-menu pre-scrollable" role="menu"> </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="chart-container">
                            <canvas id="chart" style="position: relative; height:25vh"></canvas>
                        </div>
                    </div>
                </div>



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
            <div class="col-4">
                <div class="card  ">
                    <div class="card-header">
                        <h3 class="card-title">Leaderboard</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 ">
                        <ul class="nav nav-pills flex-column" id="leader_board">

                        </ul>
                    </div>

                </div>


                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Incoming Events
                        </div>
                        <div class="card-tools">
                            <!-- <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                <i class="fas fa-sync-alt"></i>
                            </button> -->
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <?php foreach ($events_list as $event) { ?>

                            <div class="post mb-3">
                                <!-- <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                                    <a href="#">Jonathan Burke Jr.</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                             -->

                                <h5> <?php echo  $event->name ?></h5>
                                Date: <?php echo  date_format(date_create($event->date_from), 'M d, Y') . " - " .  date_format(date_create($event->date_to), 'M d, Y') ?>
                                <div class="dropdown-divider"></div>
                                <div>
                                    <span class="mr-2"> <?php echo $event->description ?></span>
                                    <?= Html::a('<i class="fa fa-eye   text-info"></i> Read more...  ', Url::toRoute(['events/view', 'id' => $event->id]), ['class' => 'text-info text-sm']) ?>
                                    ;
                                </div>
                                <iframe src="<?php echo $event->url ?>" frameborder="0"></iframe>
                            </div>
                            <br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
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

    function populate_score(results) {
        $('#leader_board').html('');
        let i = 0;
        results[0].labels.forEach(function(value) {
            let score = 0;
            results[1].datasets[i].data.forEach(function(val) {
                score += parseInt(val);
            });
            let icon = '';
            let styling = '';
            if (i == 0) {
                icon = '<i class="fas fa-award fa-lg font-weight-bold mr-2 text-warning"></i>'
                styling = 'font-weight-bold';
            } else if (i === 1) {
                icon = `<i class="fas fa-award fa-lg text-bronze font-weight-bold mr-2  "></i>`
                styling = 'font-weight-bold';
            } else if (i == 2) {
                icon = '<i class="fas fa-award fa-lg font-weight-bold mr-2 text-secondary"></i>'
                styling = 'font-weight-bold';
            }
            let li_string = '<li class="nav-item active">' +
                '                   <a href="#" class="nav-link"> ' + icon +
                '              ' + value +
                '               <span class="float-right font-weight-bold"> ' + score + '</span>'
            '               </a>' +
            '           </li>';
            $('#leader_board').append(li_string);
            i++;
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
                populate_score(results);
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
    let select_id = 0;

    document.querySelector("#event_item").addEventListener("click", (event) => {
        $('#btn_events').text(event.target.text);
        select_id = event.target.id;
        window.myChart.destroy();
        getUpdates(event.target.id);
        getTabulation(event.target.id);
        getPerformance(event.target.id);
    });

    // var x = setInterval(function() {
    //     getUpdates(select_id);
    //     getTabulation(select_id);
    //     getPerformance(select_id);

    // }, 6000);

    function getUpdates(id) {
        $("#marquee").text('');
        $.ajax({
            url: "<?php echo \Yii::$app->getUrlManager()->createUrl('site/updates') ?>",
            type: 'GET',
            data: {
                id: id
            },
            success: function(results) {
                // let marquee='';
                // for(i=0; i<results.length; i++){

                //     marquee+=results[i] ;
                // }
                $("#marquee").text(results);
            }
        });
    }
</script>

<script>
    var chart_type_perf = 'bar';
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
                    // stacked: true,
                }],
                // indexAxis: 'y',
                yAxes: [{
                    // stacked: true,
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