{% extends 'layout.tpl' %}

{% block title %}Rozpis | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Rozpis</h1>
            </div>
        </div>
    </div>

    
    {#
    <div class="row">
        <div class="col-xs-12">
            <div class="text-center">
                <ul class="pagination center-block">
                    <li><a href="#">&laquo;</a></li>
                    {% for date in dates %}
                    <li{% if nextDate == date %} class="active"{% endif %}><a href="#">{{ date | date("l d.m") }}</a></li>
                    {% endfor %}
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
            
        </div>
    </div>
    #}
    
    <div class="row">
        <div class="col-xs-12">
            <div class="well">
                <form class="form-horizontal" id="new-season" action="/nova-sezona/generate" method="post">
                <fieldset>
                <legend>Deň</legend>
                                  
                <select class="form-control" id="dateSelect">
                    {% for date in dates %}
                    <option{% if nextDate == date %} selected="selected"{% endif %} value="{{ date }}">{{ date | date("d.m l") }}</option>
                    {% endfor %}
                </select>
              </fieldset>
              </form>
            </div>
        </div>
    </div>
    

    <div class="row">
    {% for game in games %}
        {% if game.gameObj.getAttribute("won") != null %}
        <div class="col-xs-12">
            <div class="panel panel-default panel-game2 isPlayed" data-date="{{ game.dayDate }}">
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
            <div class="panel panel-default panel-game2" data-date="{{ game.dayDate }}">
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
    {% endfor %}
    </div>
    
    
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default panel-game2 isPlayed">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-9 col-sm-3 col-md-3 col-lg-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-4 panel-game--team">
                                    <span class="panel-game--team-name hasWon">Fun</span>
                                    <span class="panel-game--team-history">3-1</span>
                                </div>
                                <div class="visible-lg col-lg-4 text-center panel-game--result">
                                    <span class="panel-game--score">
                                        <span class="more">98</span>
                                        <span class="separator">:</span>
                                        <span class="less">96</span>
                                    </span>
                                    <span class="panel-game--date">22.6 14:00</span>
                                </div>
                                <div class="col-md-12 col-lg-4 panel-game--team isRight">
                                    <span class="panel-game--team-name">Blk</span>
                                    <span class="panel-game--team-history">2-0</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-3 col-sm-2 col-md-3 hidden-lg panel-game--result">
                            <span class="panel-game--score">
                                <span class="more">98</span>
                                <span class="separator">:</span>
                                <span class="less">96</span>
                            </span>
                            <span class="panel-game--date">22.6 14:00</span>
                        </div>
                    
                        <div class="hidden-xs col-sm-7 col-md-6 col-lg-12">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="shooters-list hasWon">
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Zachar</span><span class="shooters-list--points">34b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Krajňak</span><span class="shooters-list--points">27b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Ragan</span><span class="shooters-list--points">17b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Tušan</span><span class="shooters-list--points">8b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Korbel</span><span class="shooters-list--points">7b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Duda</span><span class="shooters-list--points">-2b</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="shooters-list isRight">
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Korner</span><span class="shooters-list--points">34b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Kan</span><span class="shooters-list--points">27b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Dudovič</span><span class="shooters-list--points">17b</span>
                                        </span>
                                        <span class="shooters-list--shooter">
                                            <span class="shooters-list--name">Piskor</span><span class="shooters-list--points">8b</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    
        <div class="col-xs-12">
            <div class="panel panel-default panel-game2">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 panel-game--team">
                            <span class="panel-game--team-name">4 Fun</span>
                            <span class="panel-game--team-history">3-1</span>
                        </div>
                        <div class="col-lg-4 text-center panel-game--date">Nedeľa 22th<br>14:00</div>
                        <div class="col-lg-4 text-right panel-game--team">
                            <span class="panel-game--team-name">Black street</span>
                            <span class="panel-game--team-history">2-0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    
</div>
{% endblock %}

{% block styles %}
<style>
    .pagination > .active > a { color: #FFF; background-color: #2d80e3; }

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
        .panel-game2 .panel-game--date { display: none; }
        
        .panel-game2 .panel-game--team .panel-game--team-name,
        .panel-game2 .panel-game--team .panel-game--team-history
        { float: left; }
        .panel-game2 .panel-game--team .panel-game--team-name { clear: left; }
        
        .panel-game2 .panel-game--team .panel-game--team-history { position: relative; top: 15px; padding-left: 10px; }
        
        .shooters-list { min-height: 40px; }
        .shooters-list .shooters-list--shooter { white-space: nowrap; }
        .shooters-list .shooters-list--shooter:nth-child(1) { padding-left: 5px; }
    }
    

</style>
{% endblock %}


{% block scripts %}
<script>
/*global $*/
$(function () {
    $('span.panel-game--team-name, span.shooters-list--name').tooltip({container: "body"});
    
    var $games         = $(".panel-game2");
    var $dateSelect    = $("#dateSelect");
    function ShowGamesByDate() {
        $games.addClass("hidden");
        $games.filter("[data-date='"+$dateSelect.val()+"']").removeClass("hidden");
    }
    
    $dateSelect.change(ShowGamesByDate);
    ShowGamesByDate();
});
</script>
{% endblock %}