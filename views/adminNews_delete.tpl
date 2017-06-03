{% extends 'layout.tpl' %}

{% block title %}Novinky | {% endblock %}

{% block content %}

<div class="container">
 
    <div class="row page-header form-group">
        <div class="col-xs-12">
        
            <div class="panel panel-danger">
                <div class="panel-heading">Odstrániť novinku</div>
                <div class="panel-body">Skutočne chcete odstrániť novinku?</div>
            </div>
        </div>

        <div class="col-xs-12">
            <a href="{{ router.pathFor('admin-news#remove', {id: news.id })}}" class="btn btn-danger">Odstrániť</a>
            <a href="{{ router.pathFor('admin-news') }}" class="btn btn-success">Zrušiť</a>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

<script>
var simplemde = new SimpleMDE({ element: document.getElementById("text") });
</script>
{% endblock %}
