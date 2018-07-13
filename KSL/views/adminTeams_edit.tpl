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
            <h1>Editovať tím</h1>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills">
              <li class="active"><a href="#properties" data-toggle="tab" aria-expanded="false">Vlastnosti</a></li>
              <li><a href="#players" data-toggle="tab" aria-expanded="true">Hráči</a></li>
            </ul>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="tab-content">

                <div class="tab-pane fade active in" id="properties">
                        <div class="well">
                            <form class="form-horizontal" id="new-season" action="{{ router.pathFor('admin-teams#update', { id: team.id }) }}" method="post">
                                <input type="hidden" name="id" value="{{ team.id }}">
                                <fieldset>
                                <legend>{{ team.name }}</legend>
                                <div class="form-group">
                                  <label for="name" class="col-lg-3 control-label">Názov</label>
                                  <div class="col-lg-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Názov" maxlength="5" value="{{ team.name }}" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="short" class="col-lg-3 control-label">Skratka</label>
                                  <div class="col-lg-9">
                                    <input type="text" class="form-control" id="short" name="short" placeholder="Skratka" maxlength="5" value="{{ team.short }}" required>
                                  </div>
                                </div>
                                <!--
                                <div class="form-group">
                                  <label for="short" class="col-lg-3 control-label">Kapitán</label>
                                  <div class="col-lg-9">
                                    <input type="text" class="form-control" id="captain" name="captain" placeholder="Kapitán" maxlength="5" value="{{ team.captain_id }}" required>
                                  </div>
                                </div>
                                -->

                                <div class="form-group">
                                  <div class="col-lg-9 col-lg-offset-3">
                                    <button type="reset" class="btn btn-default">Zrušiť</button>
                                    <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
                                  </div>
                                </div>
                                </fieldset>
                            </form>
                        </div>                            
                </div>
                
                <div class="tab-pane fade" id="players">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Hráči</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                               
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>
{% endblock %}
