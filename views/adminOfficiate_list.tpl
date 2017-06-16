{% extends 'layout.tpl' %}

{% block title %}Zaregistrovať tím | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Riadiť zápas</h1>
            </div>
        </div>
    </div>

  
    <div class="row">
      <div class="col-xs-12">
        <table class="table">
          {% for game in games %}
            <a href="{{ router.pathFor("admin-officiate#game", {id: game.id}) }}">{{ game.id }}</a>&nbsp;
          {% endfor %}
        </table>
      </div>
    </div>
    
</div>
{% endblock %}

{% block styles %}
<style>
.make-uppercase { text-transform: uppercase; }
</style>
{% endblock %}