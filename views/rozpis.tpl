{% extends 'layout.tpl' %}

{% block title %}Tabuľka | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Rozpis</h1>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-xs-12">
            <div class="text-center">
                <ul class="pagination center-block">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">Sobota 21.6</a></li>
                    <li class="active"><a href="#">Nedela 22.6</a></li>
                    <li><a href="#">Sobota 28.6</a></li>
                    <li><a href="#">Nedela 29.6</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
            
        </div>
    </div>
    
    <!--
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default panel-game">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 panel-game--team">
                            <img src="/images/team_bar_fun.png" width="560" height="84" alt="4Fun" class="img-responsive panel-game--bar">
                            <span class="panel-game--score">00</span>
                        </div>
                        <div class="col-lg-6 panel-game--team">
                            <img src="/images/team_bar_blk.png" width="560" height="84" alt="4Fun" class="img-responsive panel-game--bar">
                            <span class="panel-game--score">00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->

    
    <br><br>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default panel-game2 isPlayed">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 panel-game--team">
                            <span class="panel-game--team-name isWinner">4 Fun</span>
                            <span class="panel-game--team-history">3-1</span>
                            
                            <div class="shooters-list">
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
                            </div>
                        </div>
                        <div class="col-lg-4 text-center panel-game--result">
                            <span class="panel-game--score"><b>98</b>:96</span>
                            <span class="panel-game--date">22.6 14:00</span>
                        </div>
                        <div class="col-lg-4 text-right panel-game--team">
                            <span class="panel-game--team-name">Black street</span>
                            <span class="panel-game--team-history">2-0</span>
                            
                            <div class="shooters-list">
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
    
    
        <div class="col-xs-12">
            <div class="panel panel-default panel-game3 isPlayed">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="panel-game--team">
                                <span class="panel-game--team-name hasWon">4 Fun</span>
                                <span class="panel-game--team-history">3-1</span>
                            </div>
                            <div class="panel-game--team">
                                <span class="panel-game--team-name">Black street</span>
                                <span class="panel-game--team-history">2-0</span>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 text-center panel-game--result">
                            <span class="panel-game--score hasWon">98</span>
                            <span class="panel-game--score">96</span>
                        </div>
                        
                        <div class="col-lg-4 text-right shooters-list">
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
    .panel-game2 .panel-game--team-name { font-size: 28px; font-weight: 600; }
    .panel-game2.isPlayed .panel-game--team-name { color: #AAA; }
    .panel-game2.isPlayed .panel-game--team-name.isWinner { color: #000; }
    .panel-game2 .panel-game--team-history { display: block; color: #AAA; font-size: 14px; }


    .panel-game3:hover  { -webkit-box-shadow: 0 2px 5px 2px #A1A1A1; box-shadow: 0 2px 5px 2px #A1A1A1; }
    .panel-game3 .panel-game--team-name { font-size: 28px; font-weight: 600; }
    .panel-game3.isPlayed .panel-game--team-name { color: #AAA; }
    .panel-game3.isPlayed .panel-game--team-name.hasWon { color: #000; }
    .panel-game3 .panel-game--team-history { color: #AAA; font-size: 14px; }
    .panel-game3 .panel-game--score { display: block; color: #AAA; font-size: 28px; }
    .panel-game3 .panel-game--score.hasWon { color: #000; }
    
    .shooters-list .shooters-list--shooter { padding-left: 5px; }
    .shooters-list .shooters-list--shooter:nth-child(1) { padding-left: 0px; }
    .shooters-list .shooters-list--name { font-weight: 300; border-left: 0px solid #AAA; }
    .shooters-list .shooters-list--points { padding-left: 3px; }
</style>
{% endblock %}

{#
{% block scripts %}
<script>
/*global $*/
</script>
{% endblock %}
#}