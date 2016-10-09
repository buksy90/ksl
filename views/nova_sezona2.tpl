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
    
    
    {% set day = 0 %}
    {% for timestamp, game in schedule %}
      {% if timestamp|date('N') != day %}
        {# Close panel (if there is already any opened) #}
        {% if day != 0 %}
            </table>
          </div>
        </div>
        {% endif %}
        {% set day = timestamp|date('N') %}
        
        <div class="panel panel-default">
          <div class="panel-heading">{{ timestamp|date('d.m.Y') }}</div>
          <div class="panel-body">
            <table class="table">
      {% endif %}
              <tr>
                <td style="width: 20%">{{ timestamp|date('h:i') }}</td>
                <td style="width: 40%">{{ teams[game[0]].name }}</td>
                <td style="width: 40%">{{ teams[game[1]].name }}</td>
              </tr>
    {% endfor %}
        </table>
      </div>
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
});
</script>
{% endblock %}