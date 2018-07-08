{% extends 'layout.tpl' %}

{% block title %}Import | {% endblock %}

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
            <h1>Import</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Pôvodné tabuľky (počet záznamov)</div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>Tabuľka (pôvodná)</th>
                            <th class="text-center">Počet záznamov</th>
                            <th>Tabuľka (nová)</th>
                            <th class="text-center">Počet záznamov</th>
                            <th class="text-center">Akcia</th>
                        </tr>

                        {% for key, table in tables %}
                        <tr {% if table.old != table.new %}class="warning"{% endif %}>
                            <td>{{ key }}</td>
                            <td class="text-center">{{ table.old }}</td>
                            <td>{{ table.name }}</td>
                            <td class="text-center">{{ table.new }}</td>
                            <td class="text-center"><a href="{{ router.pathFor('admin-import#import', { target: table.table }) }}" class="btn btn-primary btn-sm">Importovať</a></td>
                        </tr>
                        {% endfor %}

                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
{% endblock %}
