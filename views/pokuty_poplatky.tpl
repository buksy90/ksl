{% extends 'layout.tpl' %}

{% block title %}Pokuty a poplatky | {% endblock %}

{% block content %}

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Pokuty a poplatky</h1>
            </div>
        </div>
    </div>
    
   
    <div class="row form-group">
        <div class="col-xs-12">
            
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Názov položky</th>
                        <th>Cena</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Štartovné za družstvo</td>
                        <td>40 €</td>
                    </tr>
                    <tr>
                        <td>Štartovné za jedného hráča družstva</td>
                        <td>5 €</td>
                    </tr>
                    <tr>
                        <td>Družstvo nenastúpilo v zápase s jednotnými dresmi</td>
                        <td>15 €</td>
                    </tr>
                    <tr>
                        <td>Neuznanie protestu družstva</td>
                        <td>15 €</td>
                    </tr>
                    <tr>
                        <td>Neoprávnený štart hráča</td>
                        <td>10 €</td>
                    </tr>
                    <tr>
                        <td>Neskoré nahlásenie predohrávky, dohrávky</td>
                        <td>10 €</td>
                    </tr>
                    <tr>
                        <td>Kontumácia zápasu</td>
                        <td>20 €</td>
                    </tr>
                    <tr>
                        <td>Každé vylúčenie hráča v zápase (platí hráč)</td>
                        <td>5 €</td>
                    </tr>
                    <tr>
                        <td>Poplatok za doplnenie hráča na súpisku do polovice základnej časti</td>
                        <td>5 €</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
{% endblock %}
