{% extends 'layout.tpl' %}

{% block title %}Novinky | {% endblock %}

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
            <h1>Novinky</h1>
        </div>
        <div class="col-xs-6 text-right">
            <a href="{{ router.pathFor('admin-news#new') }}" class="btn btn-success">Vytvoriť novinku</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <table class="table">
                <tr>
                    <th>Nadpis</th>
                    <th>Dátum</th>
                </tr>
                {% for new in news %}
                <tr>
                    <td>{{ new.title }}</td>
                    <td>{{ new.updated_at | date('d.m.Y H:i') }}</td>
                    <td><a href="{{ router.pathFor('admin-news#edit', { id: new.id }) }}" class="btn btn-sm btn-success">Upraviť</a></td>
                    <td><a href="{{ router.pathFor('admin-news#delete', { id: new.id }) }}" class="btn btn-sm btn-danger">Odstraniť</a></td>
                </tr>
                {% endfor %}
            </table>
        </div>
    </div>
</div>
{% endblock %}
