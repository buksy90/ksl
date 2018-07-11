{% extends 'layout.tpl' %}

{% block title %}Tímy | {% endblock %}

{% block content %}

<div class="container">

    <div class="row page-header">
        {% if message %}
        <div class="col-xs-12">
            <div class="alert {{ messageClass}} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ message }}
            </div>
        </div>
        {% endif %}

        <div class="col-xs-6">
            <h1>Tímy</h1>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills">
              <li class="active"><a href="#teams" data-toggle="tab" aria-expanded="false">Aktivne tímy</a></li>
              <li><a href="#pending-teams" data-toggle="tab" aria-expanded="true">Neschvalené tímy</a></li>
            </ul>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="tab-content">

                <div class="tab-pane fade active in" id="teams">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Poradie tímov</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="hidden-xs">Názov</th>
                                    <th>Skratka</th>
                                    <th>Kapitán</th>
                                    <th>Akcia</th>
                                </tr>
                                
                                {% for team in activeTeams %}
                                <tr>
                                    <td>{{ team.name }}</td>
                                    <td>{{ team.short }}</td>
                                    <td>
                                        {% set captain = team.GetCaptain() %}
                                        {% if captain != null %}
                                            {{ captain.name }}
                                            {{ captain.surname }}
                                        {% else %}
                                            -
                                        {% endif %}
                                    </td>
                                    <td><a href="{{ router.pathFor('admin-teams#edit', { id: team.id }) }}" class="btn btn-primary btn-sm">Editovať</a></td>
                                </tr>
                                {% endfor %}
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="pending-teams">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Strelci</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="hidden-xs">Názov</th>
                                    <th class="text-center">Skratka</th>
                                    <th>Kapitán</th>
                                </tr>
                                
                                {% for team in pendingTeams %}
                                <tr>
                                    <td>{{ team.name }}</td>
                                    <td class="text-center">{{ team.short }}</td>
                                    <td>{{ team.user_id }}</td>
                                </tr>
                                {% endfor %}
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>
{% endblock %}
