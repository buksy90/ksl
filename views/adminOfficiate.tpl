{% extends 'layout.tpl' %}

{% block title %}Riadiť zápas | {% endblock %}

{% block content %}

<div class="container setup">

</div>

<div class="container game">


    <div class="row margin-top">
      <div class="col-xs-4 col-sm-8 col-md-9">
          <div class="row">
            <div class="col-xs-12 visible-xs time-value text-center">00:00</div>
            <div class="col-xs-6 hidden-xs time-label">Čas</div>
            <div class="col-xs-6 hidden-xs time-value">00:00</div>
          </div>
          <div class="progress time-bar">
            <div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%"></div>
          </div>
      </div>
      <div class="col-xs-8 col-sm-4 col-md-3 text-right">
        <div class="btn btn-success btn-time">Štart</div>
        <div class="btn btn-default btn-settings" data-toggle="modal" data-target="#roster">Nastavenia</div>
      </div>
    </div>


    <div class="row margin-top">
      <div class="col-xs-4 team-name">{{ hometeam.short }}</div>
      <div class="col-xs-4 text-center">
        <span class="score-home">00</span>
        <span class="score-separator">:</span>
        <span class="score-away">00</span>
      </div>
      <div class="col-xs-4 team-name text-right">{{ awayteam.short }}</div>
    </div>


    <div class="row margin-top">
      <div class="col-xs-6">
        <div class="row">
          <div class="col-xs-12">
            <div class="btn btn-lg btn-primary btn-margin" data-toggle="modal" data-target="#homeroster">2pt</div>
          </div>
          <div class="col-xs-12">
            <div class="btn btn-lg btn-warning btn-margin" data-toggle="modal" data-target="#homeroster">3pt</div>
          </div>
        </div>
      </div>


      <div class="col-xs-6">
        <div class="row">
          <div class="col-xs-12">
            <div class="btn btn-lg btn-primary btn-margin pull-right" data-toggle="modal" data-target="#awayroster">2pt</div>
          </div>
          <div class="col-xs-12">
            <div class="btn btn-lg btn-warning btn-margin pull-right" data-toggle="modal" data-target="#awayroster">3pt</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <hr>
      </div>
      <div class="col-xs-12">
        <strong>FUN</strong> Zachar 2pt <span class="btn btn-sm btn-danger pull-right">X</span>
      </div>
    </div>
</div>

<div class="modal fade" id="roster" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Home roster</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-6"><h2 class="text-right">{{ hometeam.short }}</h2></div>
          <div class="col-xs-6"><h2 class="text-left">{{ awayteam.short }}</h2></div>

        {% for key, roster in {'homeroster': homeroster, 'awayroster': awayroster} %}
        <div class="col-xs-6">
          <div class="row">
              {% for player in roster %}
              <div class="col-xs-12 no-padding {% if key == 'awayroster' %}text-left{% else %}text-right{% endif %}">
                <button type="button" class="btn btn-disabled btn-margin btn-switcher" data-player-id="{{ player.id }}">
                  <span class="visible-xs">{{ player.surname }}</span>
                  <span class="hidden-xs"># {{ player.jersey }} {{ player.name }} {{ player.surname }}</span>
                </button>
              </div>
              {% endfor %}
          </div>
        </div>
        {% endfor %}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Potvrdiť</button>
      </div>
    </div>
  </div>
</div>

{% for key, roster in {'homeroster': homeroster, 'awayroster': awayroster} %}
<div class="modal fade" id="{{ key }}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Home roster</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          {% for player in roster %}
          <div class="col-xs-12 text-center">
            <button type="button" class="btn btn-primary btn-margin btn-shooter" data-player-id="{{ player.id }}" data-dismiss="modal">
              <span class="visible-xs"># {{ player.jersey }} {{ player.surname }}</span>
              <span class="hidden-xs"># {{ player.jersey }} {{ player.name }} {{ player.surname }}</span>
            </button>
          </div>
          {% endfor %}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Zrušiť</button>
      </div>
    </div>
  </div>
</div>
{% endfor %}

{% endblock %}

{% block styles %}
<style>
.btn-margin { margin: 10px; }
.margin-top { margin-top: 15px; }
.time-label { font-size: 22px; }
.time-value { font-size: 22px; }
.no-padding { padding: 0; }

.score-home, .score-away, .score-separator
{ font-size: 26px; line-height: 45px; }

.team-name { font-size: 32px; }
</style>
{% endblock %}


{% block scripts %}
<script>
(function Officiate(){
  const SECOND          = 1000;
  const MINUTE          = SECOND * 60;
  const HALF_LENGTH     = MINUTE * 30;

  function Timer() {
    var half      = 1;
    var timeLeft  = HALF_LENGTH;
    var isRunning = false;
    var interval  = null;
    var timeEl    = $(".time-value");
    var timeBtn   = $(".btn-time");
    var progressEl= $(".progress-bar");

    function updateTime() {
      if(isRunning) {
        timeLeft -= SECOND;

        var minutes   = Math.floor(timeLeft / MINUTE);
        var seconds   = (timeLeft - (minutes*MINUTE)) / SECOND;
        var progress  = 100 - (timeLeft / HALF_LENGTH) * 100;

        if(minutes < 10) minutes = "0" + String(minutes);
        if(seconds < 10) seconds = "0" + String(seconds);

        timeEl.text(minutes + ":" + seconds);
        progressEl.css("width", progress+"%");
      }
    }

    return {
      startStop: function() {
        if(isRunning) {
          isRunning = false;
          clearInterval(interval);
          timeBtn
            .addClass("btn-success")
            .removeClass("btn-danger")
            .text("Štart");
        }
        else {
          isRunning = true;
          interval = setInterval(updateTime, SECOND);
          timeBtn
            .removeClass("btn-success")
            .addClass("btn-danger")
            .text("Stop");
        }
      }
    };
  }

  function BtnSwitcher(el) {
    var $el     = $(el);
    $el.click(function(){
      $el.toggleClass("btn-primary btn-success");
    });
  }

  $(".btn-switcher").each(function(key, button){
    BtnSwitcher(button);
  });


  // Update list of players
  (function updatePlayingPlayers(){
    var $roster       = $("#roster");
    var $btnShooters  = $(".btn-shooter");

    $roster.on("hidden.bs.modal", function (){
      $btnShooters.addClass("hidden");
      $roster.find(".btn-switcher.btn-success").each(function(key, buttonSwitcher){
        $btnShooters.filter("[data-player-id='"+$(buttonSwitcher).attr("data-player-id")+"']").removeClass("hidden");
      });
    });
  })();
  

  var timer = Timer();
  $(".btn-time").click(timer.startStop);

  window.onbeforeunload = function() {
    //return "Určite chcete opustiť túto stránku?";
  }
})();
</script>
{% endblock %}