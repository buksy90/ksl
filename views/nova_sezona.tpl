{% extends 'layout.tpl' %}

{% block title %}Generovať rozpis | {% endblock %}

{% block content %}
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Nová sezóna</h1>
            </div>
        </div>
    </div>
    
    <div class="well">
        <form class="form-horizontal" id="new-season" action="{{ router.pathFor('nova-sezona#generate') }}" method="post">
            <fieldset>
            <legend>Sezóna</legend>
            <div class="form-group">
              <label for="name" class="col-lg-3 control-label">Názov</label>
              <div class="col-lg-9">
                <input type="text" class="form-control" id="name" name="name" placeholder="Názov" maxlength="5" required>
              </div>
            </div>
            <div class="form-group">
              <label for="year" class="col-lg-3 control-label">Ročník</label>
              <div class="col-lg-9">
                <input type="number" class="form-control" id="year" name="year" placeholder="Ročník" min="2015" max="2040" required>
              </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 control-label">Tímy (<span class="teams-count">0</span>)&nbsp;<br class="visible-lg"><a href="#" class="check-all">(Označiť všetky)</a></label>
                <div class="col-lg-9">
                    <div class="row">
                        {% for team in teams %}
                        <div class="col-sm-6 col-lg-4">
                            <div class="checkbox">
                                <label><input type="checkbox" name="team[{{ team.id }}]" value="1" class="team-chk"> {{ team.name }}</label>
                            </div>
                        </div>
                        {% endfor %}
                    </div>
                </div>
            </div>
            
            <div class="form-group">
              <label for="start_time" class="col-lg-3 control-label">Zápasy od</label>
              <div class="col-lg-9">
                <input type="number" class="form-control" name="start_time" id="start_time" placeholder="Čas (pm)" min="12" max="23" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="pause" class="col-lg-3 control-label">Prestávka</label>
              <div class="col-lg-9">
                <input type="number" class="form-control" name="pause" id="pause" placeholder="Prestávka medzi zápasmy (v minútach)" min="5" max="30" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="simultaneous" class="col-lg-3 control-label">Naraz zápasov</label>
              <div class="col-lg-9">
                <input type="number" class="form-control" name="simultaneous" id="simultaneous" placeholder="Počet naraz hraných zápasov" min="1" max="3" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="day_max" class="col-lg-3 control-label">Počet zápasov v jeden deň</label>
              <div class="col-lg-9">
                <select class="form-control" id="day_max" name="day_max" required>
                    <option value="auto">Automaticky (max. 1 zápas za deň na tím)</option>
                    {% for i in range(3, 8) %}
                    <option value="{{ i }}">{{ i }} (ideálne pre {{ i*2 }} tímov)</option>
                    {% endfor %}
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="simultaneous" class="col-lg-3 control-label">Hracie dni</label>
              <div class="col-lg-9">
                <div class="row">
                  {% for day in ['Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota', 'Nedeľa'] %}
                    <div class="col-sm-6">
                    <div class="checkbox"><label><input type="checkbox" name="week_days[{{ loop.index }}]" value="{{ loop.index }}">{{ day }}</label></div>
                  </div>
                  {% endfor %}
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="start" class="col-lg-3 control-label">Štart</label>
              <div class="col-lg-9">
                <input type="date" class="form-control" id="start" name="start" placeholder="Štart" min="{{ 'now'|date('Y-m-d') }}">
              </div>
            </div>
            
            <div class="form-group">
              <label for="excluded_days" class="col-lg-3 control-label">Vynechané dni</label>
              <div class="col-lg-9">
                <input type="text" class="form-control" id="excluded_days" name="excluded_days" placeholder="Dni voľna vo formáte dd.mm, oddeľte čiarkou">
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-lg-9 col-lg-offset-3">
                <button type="reset" class="btn btn-default">Zrušiť</button>
                <button type="submit" class="btn btn-primary">Vytvoriť sezónu + rozpis</button>
              </div>
            </div>
            </fieldset>
        </form>
    </div>

    

</div>
{% endblock %}

{% block styles %}
<style>
    .form-horizontal .control-label { text-align: left; }
    
    /* Large devices (large desktops, 1200px and up) screen-lg-min */
    @media (min-width: 1200px) { 
        .form-horizontal .control-label { text-align: right; }
    }
</style>
{% endblock %}


{% block scripts %}
<script>
/*global $*/
$(function () {
    $('span.panel-game--team-name, span.shooters-list--name').tooltip({container: "body"});
    
    var $teamsCount        = $(".teams-count");
    var $teamCheckboxes    = $(".team-chk");
    var statusChecked      = false;
    $(".check-all").click(function(e){
        e.preventDefault();
        
        statusChecked     = !statusChecked;
        $teamCheckboxes.prop("checked", statusChecked);
        $teamsCount.text( $teamCheckboxes.filter(":checked").length );
    });
    
    $teamCheckboxes.click(function(){
        $teamsCount.text( $teamCheckboxes.filter(":checked").length );
    });
});
</script>
{% endblock %}