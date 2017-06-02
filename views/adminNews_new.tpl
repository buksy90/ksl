{% extends 'layout.tpl' %}

{% block title %}Novinky | {% endblock %}

{% block content %}

<form action="{{ router.pathFor('admin-news#create') }}" method="post">
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
            <h1>Vytvoriť novinku</h1>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12 col-sm-4 col-md-2">Titulok</div>
        <div class="col-xs-12 col-sm-8 col-md-10"><input type="text" class="form-control" name="title" value="{{ title }}"></div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12 col-sm-4 col-md-2">Text</div>
        <div class="col-xs-12 col-sm-8 col-md-10"><textarea class="form-control" name="text">{{ text }}</textarea></div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-right">
            <input type="submit" href="{{ router.pathFor('admin-news') }}" class="btn btn-success" value="Vytvoriť">
            <a href="{{ router.pathFor('admin-news') }}" class="btn btn-danger">Zrušiť</a>
        </div>
    </div>
</div>
</form>
{% endblock %}
