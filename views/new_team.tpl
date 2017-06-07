{% extends 'layout.tpl' %}

{% block title %}Zaregistrovať tím | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Zaregistrovať tím</h1>
            </div>
        </div>
    </div>
    
    <div class="row">
      <div class="col-xs-12 alerts-container"></div>
    </div>


    {% if registered %}
    <div class="row">
      <div class="col-xs-12">
        <div class="alert alert-warning">Už máte zaregistrovaný tím "{{ registered.name }}" ktorý čaká na schválenie.</div>
      </div>
      <div class="col-xs-12 text-right">
        <a href="{{ router.pathFor('team#cancel') }}" class="btn btn-danger">Zrušiť registráciu</a>
      </div>
    </div>
    {% else %}
    <div class="row">
      <div class="col-xs-12">
        <div class="alert alert-info">Po vytvorení tímu bude tím čakať na schválenie od administratora. Po schválení bude tím viditeľný na stránke a bude možné pridávať hráčov.</div>
      </div>
    </div>

    <div class="well">
        <form class="form-horizontal" id="new-season" action="{{ router.pathFor('team#register') }}" method="post">
            <fieldset>
            <legend>Tím</legend>
            <div class="form-group">
              <label for="name" class="col-lg-3 control-label">Názov</label>
              <div class="col-lg-9">
                <input type="text" class="form-control" id="name" name="name" placeholder="Názov" maxlength="32" required>
              </div>
            </div>
            <div class="form-group">
              <label for="short" class="col-lg-3 control-label">Skratka (3 znaky)</label>
              <div class="col-lg-9">
                <input type="text" class="form-control make-uppercase" id="short" name="short" placeholder="skratka" maxlength="3" minlength="3" pattern=".{3}" title="Skratka musí pozostávať z troch znakov" required>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-lg-9 col-lg-offset-3">
                <button type="reset" class="btn btn-default">Zrušiť</button>
                <button type="submit" class="btn btn-primary">Vytvoriť tím</button>
              </div>
            </div>
            </fieldset>
        </form>
    </div>
    {% endif %}
</div>
{% endblock %}

{% block styles %}
<style>
.make-uppercase { text-transform: uppercase; }
</style>
{% endblock %}