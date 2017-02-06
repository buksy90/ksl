{% extends 'layout.tpl' %}

{% block title %}{{ team.name }} | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>{{ team.name }}</h1>
            </div>
        </div>
    </div>
    
    
    
    
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ team.short }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <strong class="col-xs-6 col-sm-5 bold">Názov:</strong>
                        <div class="col-xs-6 col-sm-7">{{ team.name }}</div>
                        <strong class="col-xs-6 col-sm-5 bold">Skratka:</strong>
                        <div class="col-xs-6 col-sm-7">{{ team.short }}</div>
                        <strong class="col-xs-6 col-sm-5 bold">Kapitán:</strong>
                        <div class="col-xs-6 col-sm-7">
                            {% set captain = team.GetCaptain() %}
                            {% if captain != null %}
                                {{ captain.name }}
                                {{ captain.surname }}
                            {% endif %}
                        </div>
                        <strong class="col-xs-6 col-sm-5 bold">Najlepší strelec:</strong>
                        <div class="col-xs-6 col-sm-7">
                            {% set shooter = team.GetBestShooter() %}
                            {% if shooter %}
                                {{ shooter.player.name }}
                                {{ shooter.player.surname }},
                                {{ shooter.score }}b
                            {% else %}
                                Nie je
                            {% endif %}
                        </div>
                        <strong class="col-xs-6 col-sm-5 bold">Počet hráčov:</strong>
                        <div class="col-xs-6 col-sm-7">{{ team.GetPlayersCount() }}</div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Štatistiky</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
<script>
console.warn("TODO: next lines !");
</script>
                        <strong class="col-xs-9 bold">Odohraté zápasy:</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Výhry:</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Prehry:</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Umiestnenie:</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Strelené body:</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Strelené body (priemer):</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Inkasované body:</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Inkasované body (priemer):</strong>
                        <div class="col-xs-3">0</div>
                        <strong class="col-xs-9 bold">Úspešnosť:</strong>
                        <div class="col-xs-3">0%</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
            <ul class="nav nav-pills">
              <li class="active"><a href="#games" data-toggle="tab" aria-expanded="false">Zápasy</a></li>
              <li><a href="#players" data-toggle="tab" aria-expanded="true">Hráči</a></li>
              <li><a href="#history-standings" data-toggle="tab" aria-expanded="true">Umiestnenie</a></li>
            </ul>
            
            <br>
            
            <div id="stat-tables" class="tab-content">
                <div class="tab-pane fade active in" id="games">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Zápasy</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="text-center">Dátum</th>
                                    <th class="text-center">Domáci</th>
                                    <th class="text-center">Hostia</th>
                                    <th class="text-center">Skóre</th>
                                </tr>
                                
                                {% for game in games %}
                                <tr>
                                    <td class="text-center">
                                        <span class="visible-xs">{{ game.date | date("d.m") }}</span>
                                        <span class="hidden-xs">{{ game.date | date("d.m l") }}</span>
                                    </td>
                                    <td class="text-center">{{ teams[game.hometeam].short }}</td>
                                    <td class="text-center">{{ teams[game.awayteam].short }}</td>
                                    <td class="text-center">{{ game.getAttribute('home_score') }}:{{ game.getAttribute('away_score') }}</td>
                                </tr>
                                {% endfor %}
                                
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="players">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Hráči</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="hidden-xs text-center">Poradie</th>
                                    <th>Hráč</th>
                                    <th class="hidden-xs">Tým</th>
                                    <th class="text-center">Zápasy</th>
                                    <th class="text-center">Body</th>
                                    <th class="text-center">Priemer</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="history-standings">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Umiestnenie</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="standings-chart" style="min-height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
{% endblock %}


{% block scripts %}
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/highcharts.js"></script>
<script>
/*global $*/
$(function(){
    $('#2pt-players .tooltip-target').tooltip({container: 'body'});
    
    
    
    Highcharts.chart('standings-chart', {
    title: {
        text: '',
        style: {
            display: 'none'
        }
    },
    xAxis: {
        categories: ['1. kolo', '2. kolo', '3. kolo', '4. kolo', '5. kolo', '6. kolo'],
        title: 'Kolo'
    },
    yAxis: {
        title: {
            text: 'Umiestnenie'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },
    tooltip: {
        valueSuffix: '°C'
    },
    legend: {
        align: 'center',
        verticalAlign: 'bottom',
        x: 0,
        y: 0
    },
    series: [{
        name: 'FUN',
        data: [0, 1, 2, 2, 3, 2]
    }, {
        name: 'BLK',
        data: [0, 2, 1, 1, 1, 1]
    }, {
        name: 'TYD',
        data: [0, 3, 3, 3, 2, 3]
    }]
});
});
</script>
{% endblock %}