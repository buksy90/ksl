{% extends 'layout.tpl' %}

{% block title %}Tabuľka | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Tabuľky</h1>
            </div>
        </div>
    </div>
    
    
    
    
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-pills">
              <li class="active"><a href="#teams" data-toggle="tab" aria-expanded="false">Poradie tímov</a></li>
              <li><a href="#2pt-players" data-toggle="tab" aria-expanded="true">Strelci</a></li>
              <li><a href="#3pt-players" data-toggle="tab" aria-expanded="true">3 bodový strelci</a></li>
            </ul>
            
            <br>
            
            <div id="stat-tables" class="tab-content">
                <div class="tab-pane fade active in" id="teams">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Poradie tímov</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="hidden-xs text-center">Poradie</th>
                                    <th>Názov týmu</th>
                                    <th class="hidden-xs hidden-sm text-center">Skóre</th>
                                    <th class="text-center">Z</th>
                                    <th class="text-center">V</th>
                                    <th class="text-center">P</th>
                                    <th class="text-center">Body</th>
                                    <th class="hidden-xs text-center">Úspešnosť</th>
                                </tr>
                                
                                {% for team in teams %}
                                <tr>
                                    <td class="hidden-xs text-center">{{ loop.index }}</td>
                                    <td>{{ team.teamObj.name }}</td>
                                    <td class="hidden-xs hidden-sm text-center" title="Skóre">{{ team.scored }}:{{ team.received }}</td>
                                    <td class="text-center">{{ team.games }}</td>
                                    <td class="text-center">{{ team.won }}</td>
                                    <td class="text-center">{{ team.lost }}</td>
                                    <td class="text-center">{{ team.points}}</td>
                                    <td class="hidden-xs text-center" title="Úspešnosť">{{ team.success }}%</td>
                                </tr>
                                {% endfor %}
                            </table>
                        </div>
                    </div>
                    
                    <p class="bg-info">O poradí pri rovnosti bodov rozhodujú vzájomné zápasy medzi družstvami.</p>
                </div>
                
                
                <div class="tab-pane fade" id="2pt-players">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Strelci</div>
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
                                
                                {% for player in shooters %}
                                <tr>
                                    <td class="hidden-xs text-center">{{ loop.index }}</td>
                                    <td><span class="tooltip-target" data-toggle="tooltip" data-placement="top" data-original-title="{{ player.playerObj.nick }}">{{ player.playerObj.name }} {{ player.playerObj.surname }}</span></td>
                                    <td class="hidden-xs">{{ player.team }}</td>
                                    <td class="text-center">{{ player.games }}</td>
                                    <td class="text-center">{{ player.points }}</td>
                                    <td class="text-center">{{ player.avg }}</td>
                                </tr>
                                {% endfor %}
                            </table>
                        </div>
                    </div>
                    
                    <p class="bg-info">Do celkového poradia budú zaradení len hráči, ktorí odohrali 50% všetkých zápasov družstva !</p>
                </div>
                
                
                <div class="tab-pane fade" id="3pt-players">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Strelci</div>
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
                                
                                {% for player in shooters3pt %}
                                <tr>
                                    <td class="hidden-xs text-center">{{ loop.index }}</td>
                                    <td><span class="tooltip-target" data-toggle="tooltip" data-placement="top" data-original-title="{{ player.playerObj.nick }}">{{ player.playerObj.name }} {{ player.playerObj.surname }}</span></td>
                                    <td class="hidden-xs">{{ player.team }}</td>
                                    <td class="text-center">{{ player.games }}</td>
                                    <td class="text-center">{{ player.points }}</td>
                                    <td class="text-center">{{ player.avg }}</td>
                                </tr>
                                {% endfor %}
                            </table>
                        </div>
                    </div>
                    
                    <p class="bg-info">Do celkového poradia budú zaradení len hráči, ktorí odohrali 50% všetkých zápasov družstva !</p>
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