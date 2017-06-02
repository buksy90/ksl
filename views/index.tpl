{% extends 'layout.tpl' %}



{% block content %}
<div class="container-fluid silver-gradient">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-8">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-header">
                                    <h2>Najbližšie zápasy</h2>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                        {% for game in games %}
                            {% if game.gameObj.getAttribute("won") != null %}
                            <div class="col-xs-12">
                                <div class="panel panel-default panel-game2 isPlayed">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-9 col-sm-3 col-md-3 col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-4 panel-game--team">
                                                        <span class="panel-game--team-name{%if game.gameObj.getAttribute("won") == 'home' %} hasWon{% endif %}" data-toggle="tooltip" data-placement="top" title="{{ game.homeTeam.name }}">{{ game.homeTeam.short }}</span>
                                                        <span class="panel-game--team-history">{{ game.homeHistory.won }}-{{ game.homeHistory.lost }}</span>
                                                    </div>
                                                    <div class="visible-lg col-lg-4 text-center panel-game--result">
                                                        <span class="panel-game--score">
                                                            <span class="more">{{ game.gameObj.getAttribute("home_score") }}</span>
                                                            <span class="separator">:</span>
                                                            <span class="less">{{ game.gameObj.getAttribute("away_score") }}</span>
                                                        </span>
                                                        <span class="panel-game--date">{{ game.gameObj.date | date('d.m.Y H:i') }}</span>
                                                    </div>
                                                    <div class="col-md-12 col-lg-4 panel-game--team isRight">
                                                        <span class="panel-game--team-name{% if game.gameObj.getAttribute("won") == 'away' %} hasWon{% endif %}" data-toggle="tooltip" data-placement="top" title="{{ game.awayTeam.name }}">{{ game.awayTeam.short }}</span>
                                                        <span class="panel-game--team-history">{{ game.awayHistory.won }}-{{ game.awayHistory.lost }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-3 col-sm-2 col-md-3 hidden-lg panel-game--result">
                                                <span class="panel-game--score">
                                                    <span class="more">{{ game.gameObj.getAttribute("home_score") }}</span>
                                                    <span class="separator">:</span>
                                                    <span class="less">{{ game.gameObj.getAttribute("away_score") }}</span>
                                                </span>
                                                <span class="panel-game--date">{{ game.gameObj.date | date('d.m.Y H:i') }}</span>
                                            </div>
                                        
                                            <div class="hidden-xs col-sm-7 col-md-6 col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="shooters-list{% if game.gameObj.getAttribute("won") == 'home' %} hasWon{% endif %}">
                                                            {% for shooter in game.homeScoreList %}
                                                            <span class="shooters-list--shooter">
                                                                <span class="shooters-list--name" data-toggle="tooltip" data-placement="top" title="{{ players[shooter.player_id].name }} {{ players[shooter.player_id].surname }}">{{ players[shooter.player_id].nick | default(players[shooter.player_id].surname) }}</span>
                                                                <span class="shooters-list--points">{{ shooter.sum }}b</span>
                                                            </span>
                                                            {% endfor %}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="shooters-list isRight{% if game.gameObj.getAttribute("won") == 'away' %} hasWon{% endif %}">
                                                            {% for shooter in game.awayScoreList %}
                                                            <span class="shooters-list--shooter">
                                                                <span class="shooters-list--name" data-toggle="tooltip" data-placement="top" title="{{ players[shooter.player_id].name }} {{ players[shooter.player_id].surname }}">{{ players[shooter.player_id].nick | default(players[shooter.player_id].surname) }}</span>
                                                                <span class="shooters-list--points">{{ shooter.sum }}b</span>
                                                            </span>
                                                            {% endfor %}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {% else %}
                            <div class="col-xs-12">
                                <div class="panel panel-default panel-game2">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-4 panel-game--team">
                                                <span class="panel-game--team-name" data-toggle="tooltip" data-placement="top" title="{{ game.homeTeam.name }}">{{ game.homeTeam.short }}</span>
                                                <span class="panel-game--team-history">{{ game.homeHistory.won }}-{{ game.homeHistory.lost }}</span>
                                            </div>
                                            <div class="col-lg-4 text-center panel-game--date">{{ game.gameObj.date | date('l dS') }}<br>{{ game.gameObj.date | date('H:i') }}</div>
                                            <div class="col-lg-4 text-right panel-game--team">
                                                <span class="panel-game--team-name" data-toggle="tooltip" data-placement="top" title="{{ game.awayTeam.name }}">{{ game.awayTeam.short }}</span>
                                                <span class="panel-game--team-history">{{ game.awayHistory.won }}-{{ game.awayHistory.lost }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {% endif %}
                        {% else %}
                            <div class="alert alert-dismissible alert-warning">
                              <p>Žiadne ďalšie zápasy nie sú naplánované.</p>
                            </div>
                        {% endfor %}
                        </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-header">
                                    <h2>Predpoveď počasia</h2>
                                </div>
                            </div>
                        </div>
                        
                        <!--
                        
                        free vector icons that can be used
                        http://4vector.com/free-vector/weather-icons-vector-19544 
                        
                        -->
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="nav nav-pills">
                                    {% for i in 0..1 %}
                                    <li class="{% if loop.first %}active{% endif %}"><a href="#d{{ weather[i].timestamp }}" data-toggle="tab" aria-expanded="false">{{ weather[i].timestamp|date('d.m.Y l') }}</a></li>
                                    {% endfor %}
                                </ul>
                                
                                <div id="weather" class="tab-content">
                                    {% for i in 0..1 %}
                                        <div class="tab-pane fade {% if loop.first %}active in{% endif %}" id="d{{ weather[i].timestamp }}">
                                          <div class="row">
                                              <div class="col-xs-8 col-xs-push-2 text-center">
                                                  <img class="img-responsive block-center" src="/images/weather/rain.png" alt="rain" style="filter: hue-rotate(360deg)">
                                                  <br>
                                                  {{ weather[i].timestamp|date('d.m.Y l') }}, <strong>{# {{ array_sum(weather[i].temperatur)}} #}X°</strong>
                                              </div>
                                          </div>
                                        </div>
                                    {% endfor %}
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Novinky</h1>
            </div>
        </div>
    </div>
    
    <div class="row">
        {% for new in news %}
        <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <h3>{{ new.title }}</h3>
                <p>{{ new.text | raw }}</p>
              </div>
            </div>
        </div>
        {% endfor %}

        <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <h3>Víťazom 21. ročníka KSL sa stalo DŽUNGELEE</h3>
                <p>Po šiestich triumfoch na Amurskej ulici prepísali chlapci a dievčenská posila z družstva SMRŤ PRICHÁDZA Z DŽUNGELEE históriu a po 7 rokoch...</p>
              </div>
            </div>
        </div>
        
        <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <h3>DŽUNGELEE víťazom pohára 2016</h3>
                <p>Družstvo SMRŤ PRICHÁDZA Z DŽUNGELEE získalo po 4 rokoch opäť Streetballový pohár. Po víťazstvach 100:78 nad #TYDAMBOJZ a 100:89 nad 4FUN...</p>
              </div>
            </div>
        </div>
        
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Streetballový pohár 2016</h3>
                    <p>DružstvoUž túto nedeľu 21. augusta 2016 sa uskutoční 20. ročník Streetballového pohára. Tento rok sa záujem o túto trofej mierne zväčšil a tak si to medzi sebou rozdajú až 3 družstvá. K tradičnému účastnikovi družstvu 4FUN sa pridali aj chlapci z #TYDAMBOJZ. Trojku doplnia cestovatelia z DŽUNGELEE na čele zo svojím čestvo oženeným kapitánom Jozefom. Hrá sa každý s každým a veríme, že nás čaká príjemné streetballové nedeľňajšie popoludnie.</p>
                </div>
            </div>
        </div>
    </div>
    
    {#
    <div class="row">
        <div class="col-xs-12 text-center">
            <ul class="pagination">
              <li class="disabled"><a href="#">&laquo;</a></li>
              <li class="active"><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">&raquo;</a></li>
            </ul>
        </div>
    </div>
    #}
</section>
    
    
</div>
{% endblock %}

{% block styles %}
<style>
    .pagination > .active > a { color: #FFF; background-color: #2d80e3; }

    .panel-game2 { position: relative; }
    .panel-game2:hover  { -webkit-box-shadow: 0 2px 5px 2px #A1A1A1; box-shadow: 0 2px 5px 2px #A1A1A1; }
    .panel-game2 .panel-game--date { display: block; font-size: 22px; }
    .panel-game2.isPlayed .panel-game--date { font-size: 14px; color: #AAA; }
    .panel-game2 .panel-game--result { font-size: 28px; color: #AAA; }
    .panel-game2 .panel-game--result b { color: #000; }
    .panel-game2 .panel-game--team-name { font-size: 28px; font-weight: 600; text-transform: uppercase; }
    .panel-game2 .panel-game--score .more { color: #000; }
    .panel-game2.isPlayed .panel-game--team-name { color: #AAA; }
    .panel-game2.isPlayed .panel-game--team-name.hasWon { color: #000; }
    .panel-game2 .panel-game--team-history { display: block; color: #AAA; font-size: 14px; }


    .panel-game3:hover  { -webkit-box-shadow: 0 2px 5px 2px #A1A1A1; box-shadow: 0 2px 5px 2px #A1A1A1; }
    .panel-game3 .panel-game--team-name { font-size: 28px; font-weight: 600; text-transform: uppercase; }
    .panel-game3.isPlayed .panel-game--team-name { color: #AAA; }
    .panel-game3.isPlayed .panel-game--team-name.hasWon { color: #000; }
    .panel-game3 .panel-game--team-history { color: #AAA; font-size: 14px; }
    .panel-game3 .panel-game--score { display: block; color: #AAA; font-size: 28px; }
    .panel-game3 .panel-game--score.hasWon { color: #000; }
    
    .shooters-list { color: #AAA; }
    .shooters-list.hasWon { color: #000; }
    .shooters-list .shooters-list--shooter { padding-left: 5px; }
    .shooters-list .shooters-list--shooter:nth-child(1) { padding-left: 0px; }
    .shooters-list .shooters-list--name { font-weight: 300; border-left: 0px solid #AAA; }
    .shooters-list .shooters-list--points { padding-left: 3px; }
    
    
    
    /* Extra small devices (phones, less than 768px) */
    /* No media query since this is the default in Bootstrap */
    
    
    /* Small devices (tablets, 768px and up) */
    @media (min-width: @screen-sm-min) {  }
    
    /* Medium devices (desktops, 992px and up) */
    @media (min-width: @screen-md-min) {  }
    
    /* Large devices (large desktops, 1200px and up) screen-lg-min */
    @media (min-width: 1200px) { 
        .panel-game2 .panel-game--team.isRight { text-align: right; }
        .panel-game2 .shooters-list.isRight { text-align: right; }
    }
    
    
    /* XS, SM, MD */
    @media (max-width: 1199px) { 
        .panel-game2 .panel-game--score .more, 
        .panel-game2 .panel-game--score .less 
        { display: block; }
        
        .panel-game2 .panel-game--score .separator { display: none; }
        .panel-game2 .panel-game--date { 
            position: absolute;
            right: 15px;
            top: 25px;
        }
        
        .panel-game2 .panel-game--team .panel-game--team-name,
        .panel-game2 .panel-game--team .panel-game--team-history
        { float: left; }
        .panel-game2 .panel-game--team .panel-game--team-name { clear: left; }
        
        .panel-game2 .panel-game--team .panel-game--team-history { position: relative; top: 15px; padding-left: 10px; }
        
        .shooters-list { min-height: 40px; }
        .shooters-list .shooters-list--shooter { white-space: nowrap; }
        .shooters-list .shooters-list--shooter:nth-child(1) { padding-left: 5px; }
    }
    
    .silver-gradient {
        background: #efefef; /* Old browsers */
        background: -moz-linear-gradient(top, #efefef 0%, #f3f3f3 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #efefef 0%,#f3f3f3 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #efefef 0%,#f3f3f3 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#efefef', endColorstr='#f3f3f3',GradientType=0 ); /* IE6-9 */
    }
</style>
{% endblock %}


{% block scripts %}
<script>
/*global $*/
$(function () {
    $('span.panel-game--team-name, span.shooters-list--name').tooltip({container: "body"});
});
</script>
{% endblock %}