{% extends 'layout.tpl' %}

{% block title %}Novinky | {% endblock %}

{% block content %}

{% if isEditting %}
<form action="{{ router.pathFor('admin-news#update', { id: news.id }) }}" method="post">
<input type="hidden" name="id" value="{{ news.id }}">
{% else %}
<form action="{{ router.pathFor('admin-news#create') }}" method="post">
{% endif %}
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
            <h1>
                {% if isEditting %}Editovať novinku{% else %}Vytvoriť novinku{% endif %}
            </h1>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12 col-sm-4 col-md-2">Titulok</div>
        <div class="col-xs-12 col-sm-8 col-md-10"><input type="text" class="form-control" name="title" value="{{ title }}"></div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12 col-sm-4 col-md-2">Text</div>
        <div class="col-xs-12 col-sm-8 col-md-10"><textarea class="form-control" name="text" id="text">{{ text }}</textarea></div>
    </div>

    <div class="row">
        <div class="col-xs-12 text-right">
            {% if isEditting %}
            <input type="submit" class="btn btn-success" value="Upraviť">
            {% else %}
            <input type="submit" class="btn btn-success" value="Vytvoriť">
            {% endif %}
            <a href="{{ router.pathFor('admin-news') }}" class="btn btn-danger">Zrušiť</a>
        </div>
    </div>
</div>
</form>
{% endblock %}

{% block scripts %}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

<script>
var simplemde = new SimpleMDE({ element: document.getElementById("text") });
</script>
{% endblock %}
