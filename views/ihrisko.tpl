{% extends 'layout.tpl' %}

{% block title %}{{ playground.name }} | {% endblock %}

{% block content %}

<div class="container-fluid">
    <div class="row">
        <div id="map" style="width: 100%; height: 50vh; min-height: 250px; max-height: 500px;"></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Ihrisko {{ playground.name }}</h1>
            </div>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-pills">
              <li class="active"><a href="#next-games" data-toggle="tab" aria-expanded="false">Najbližšie zápasy</a></li>
              <li><a href="#gallery" data-toggle="tab" aria-expanded="true">Galéria</a></li>
            </ul>
            
            <br>
            
            <div class="tab-content">
                <div class="tab-pane fade active in" id="next-games">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Najbližšie zápasy</div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="text-center">Dátum</th>
                                    <th class="text-center">Domáci</th>
                                    <th class="text-center">Hostia</th>
                                </tr>
                                
                                {% for game in games %}
                                <tr>
                                    <td class="text-center">{{ game.date | date('d.m.Y h:i') }}</td>
                                    <td class="text-center"><span class="tooltip-target" data-toggle="tooltip" data-placement="top" data-original-title="{{ game.homeTeam.name }}">{{ game.homeTeam.short }}</span></td>
                                    <td class="text-center"><span class="tooltip-target" data-toggle="tooltip" data-placement="top" data-original-title="{{ game.awayTeam.name }}">{{ game.awayTeam.short }}</span></td>
                                </tr>
                                {% endfor %}
                            </table>
                        </div>
                    </div>
                </div>
                
                
                <div class="tab-pane fade" id="gallery">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Galéria</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4">
                                    <img class="img-responsive img-thumbnail" src="/images/playgrounds/amurska.jpg"></img>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    
</div>
{% endblock %}

{% block scripts %}
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
/*global $*/
$(function(){
    var playground = { lat: {{ playground.latitude }}, lng: {{ playground.longitude }} };
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 14,
      center: playground
    });
    var marker = new google.maps.Marker({
      position: playground,
      map: map
    });
    
    $('#next-games .tooltip-target').tooltip({container: 'body'});
});
</script>
{% endblock %}