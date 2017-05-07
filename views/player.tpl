{% extends 'layout.tpl' %}

{% block title %}{{ player.name }} {{ player.surname }} | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>{{ player.name }} {{ player.surname }}</h1>
            </div>
        </div>
    </div>
    
    
    
    
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">BIO</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <img src="{{ image }}" class="img-responsive">
                        </div>
                    </div>
                    <div class="row">
                        <strong class="col-xs-7 bold">Tím:</strong>
                        <div class="col-xs-5">
                            <a href="/teams/{{ team.short }}">{{ team.name }}</a>
                        </div>
                        {% if player.nick %}
                            <strong class="col-xs-7 bold">Prezývka:</strong>
                            <div class="col-xs-5">{{ player.nick }}</div>
                        {% endif %}
                        <strong class="col-xs-7 bold">Číslo dresu:</strong>
                        <div class="col-xs-5">{{ player.jersey }}</div>
                        <strong class="col-xs-7 bold">Facebook:</strong>
                        <div class="col-xs-5">
                            <a href="http://facebook.com">Facebook</a>
                        </div>
                        <strong class="col-xs-7 bold">Vek:</strong>
                        <div class="col-xs-5">{{ player.birthdate }}</div>
                        <strong class="col-xs-7 bold">Kategória:</strong>
                        <div class="col-xs-5">{{ player.category }}</div>
                        <strong class="col-xs-7 bold">Rank:</strong>
                        <div class="col-xs-5">{{ playerRank }}</div>
                        <strong class="col-xs-7 bold">Overall:</strong>
                        <div class="col-xs-5">{{ playerOverall }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
            <ul class="nav nav-pills">
                <li class="active"><a href="#statistics" data-toggle="tab">Štatistiky</a></li>
                <li><a href="#games" data-toggle="tab">Zápasy</a></li>
            </ul>
            
            <br>
            
            <div id="stat-tables" class="tab-content">
                <div class="tab-pane fade active in" id="statistics">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Štatistiky</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>Počet odohratých zápasov</th>
                                    <td>{{ gamesPlayedCount }}</td>
                                </tr>
                                <tr>
                                    <th>Počet vyhratých zápasov</th>
                                    <td>{{ gamesWonCount }}</td>
                                </tr>
                                <tr>
                                    <th>Počet prehratých zápasov</th>
                                    <td>{{ gamesLostCount }}</td>
                                </tr>
                                <tr>
                                    <th>Zápasová úspešnosť</th>
                                    <td>{{ gamesSuccessRate }}</td>
                                </tr>
                                <tr>
                                    <th>Počet strelených bodov</th>
                                    <td>{{ scoredPoints }}</td>
                                </tr>
                                <tr>
                                    <th>Počet premenených trojkových pokusov</th>
                                    <td>{{ threePointsMade }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                <div class="tab-pane fade" id="games">
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
                                
                            </table>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    
</div>
{% endblock %}

