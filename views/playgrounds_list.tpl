{% extends 'layout.tpl' %}

{% block title %}Ihriská | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Ihriská</h1>
            </div>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Zoznam ihrísk</div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        {% for playground in playgrounds %}
                        <tr>
                            <td><a href="{{ router.pathFor('playgroundByLink', {'link': playground.link}) }}">{{ playground.name }}</a></td>
                            <td class="text-center">{{ playground.address}}</td>
                            <td class="text-center">{{ playground.district}}</td>
                        </tr>
                        {% endfor %}
                    </table>
                </div>
            </div>


        </div>
    </div>
    
</div>
{% endblock %}