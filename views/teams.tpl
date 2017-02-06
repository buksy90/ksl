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
        <div class="col-xs-12">
            <ul class="nav nav-pills">
              <li class="active"><a href="#games" data-toggle="tab" aria-expanded="false">Zápasy</a></li>
              <li><a href="#players" data-toggle="tab" aria-expanded="true">Hráči</a></li>
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
            </div>
        </div>
    </div>
    
</div>
{% endblock %}

{% block scripts %}
<script>
/*global $*/
$(function(){
    $('#2pt-players .tooltip-target').tooltip({container: 'body'});
});
</script>
{% endblock %}