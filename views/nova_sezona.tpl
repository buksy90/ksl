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
    
    <div class="row">
      <div class="col-xs-12 alerts-container"></div>
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
              <label for="simultaneous" class="col-lg-3 control-label">Počet súbežnych zápasov</label>
              <div class="col-lg-9">
                <input type="number" class="form-control" name="simultaneous" id="simultaneous" placeholder="Počet naraz hraných zápasov" min="1" max="3" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="day_max" class="col-lg-3 control-label">Max. počet zápasov / deň</label>
              <div class="col-lg-9">
                <select class="form-control" id="day_max" name="day_max" required>
                    <option value="0">Automaticky (max. 1 zápas na deň za tím)</option>
                    {% for i in range(3, 8) %}
                    <option value="{{ i }}">{{ i }} (ideálne pre {{ i*2 }} tímov)</option>
                    {% endfor %}
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="day_max" class="col-lg-3 control-label">Max. počet zápasov tímu / deň</label>
              <div class="col-lg-9">
                <select class="form-control" id="team_day_max" name="team_day_max" required>
                    {% for i in range(1, 3) %}
                    <option value="{{ i }}">Jeden tím môže za deň odohrať maximálne <b>{{ i }}</b> zápasy</option>
                    {% endfor %}
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label for="simultaneous" class="col-lg-3 control-label">Hracie dni&nbsp;<br class="visible-lg"><a href="#" class="check-weekend">(Označiť víkend)</a></label>
              <div class="col-lg-9">
                <div class="row">
                  {% for day in ['Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota', 'Nedeľa'] %}
                    <div class="col-sm-6">
                    <div class="checkbox"><label><input type="checkbox" name="week_days[{{ loop.index }}]" class="week_day week_day{{ loop.index }}" value="{{ loop.index }}">{{ day }}</label></div>
                  </div>
                  {% endfor %}
                </div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="start" class="col-lg-3 control-label">Štart</label>
              <div class="col-lg-9">
                <input type="date" class="form-control" id="start" name="start" placeholder="Štart" min="{{ 'now'|date('Y-m-d') }}" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="excluded_days" class="col-lg-3 control-label">Vynechané dni</label>
              <div class="col-lg-9">
                <input type="text" class="form-control" id="excluded_days" name="excluded_days" placeholder="Dni voľna vo formáte dd.mm, oddeľte čiarkou">
              </div>
            </div>
            
            <div class="form-group">
              <label for="playgrounds" class="col-lg-3 control-label">Ihriská</label>
              <div class="col-lg-9">
                <div class="row">
                  {% for playground in playgrounds %}
                    <div class="col-sm-6">
                      <div class="checkbox"><label><input type="checkbox" name="playgrounds[]" class="playground" value="{{ playground.id }}">{{ playground.name }}</label></div>
                  </div>
                  {% endfor %}
                </div>
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
    var $weekendCheckboxes = $(".week_day6, .week_day7");
    var $weekDays          = $(".week_day");
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
    
    
    $(".check-weekend").click(function(e){
      e.preventDefault();
      $weekendCheckboxes.prop("checked", true);
    });
    
    
    var ShowWarning = (function() {
      /*
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Oh snap!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again.
      </div>
      */
      var d = $("<div>").addClass("alert alert-dismissible alert-danger");
      var b = $("<button>").attr("type", "button").addClass("close").attr("data-dismiss", "alert").html("&times;");
      var t = $("<label>");
      var container = $(".alerts-container");
      var menuHeight = $("nav.navbar").height();
      
      d.append(b).append(t);
      
      return function(text, forElement) {
        if(text === undefined) return container.empty();
        
        $('html, body').animate({ scrollTop: container.offset().top - menuHeight }, 200);
        t.text(text).attr("for", forElement);
        return container.append(d.clone(true));
      }
    })();
    
    $("#new-season").submit(function(e){
      var success = true;
      ShowWarning();
      
      if($teamCheckboxes.filter(":checked").length === 0) {
        ShowWarning("Je potrebné vybrať aspoň dva tímy.");
        success = false;
      }
      
      if($weekDays.filter(":checked").length === 0) {
        ShowWarning("Vyberte si hracie dni");
        success = false;
      }
      
      return success;
    });
});
</script>
{% endblock %}