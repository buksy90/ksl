<!DOCTYPE html>
<html lang="" data-ng-app="referee">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{% block title %}{% endblock %}KSL.sk</title>

		<script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
		<script type="text/javascript" src="https://code.angularjs.org/1.5.8/angular-route.min.js"></script>

		<!-- Bootstrap CSS -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		-->
		<link rel="stylesheet" href="/css/bootstrap.css" media="screen">
		<link rel="stylesheet" href="/css/bootstrap.custom.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<style>
			p { text-align: justify; }
			.bootstrap-helper {
				position: fixed;
				bottom: 10px;
				right: 10px;
				width: 20px;
				height: 20px;
				background-color: #000;
				color: #FFF;
				text-align: center;
				opacity: 0.3;
				z-index: 9999;
			}
			
			.bg-primary, .bg-success, .bg-info, .bg-warning, .bg-danger { padding: 15px; color: #FFF; }
		</style>
		{% block styles %}{% endblock %}
	</head>
	<body data-ng-controller="MainController as main">
		<div class="bootstrap-helper">
			<div class="visible-xs">XS</div>
			<div class="visible-sm">SM</div>
			<div class="visible-md">MD</div>
			<div class="visible-lg">LG</div>
		</div>
		
		{% block navbar %}
		<nav class="navbar navbar-default navbar-fixed-top">
		  	<div class="container">
			    <div class="navbar-header"> 
			    	<button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9" aria-expanded="false"> 
			    		<span class="sr-only">Toggle navigation</span> 
			    		<span class="icon-bar"></span> 
			    		<span class="icon-bar"></span> 
			    		<span class="icon-bar"></span> 
		    		</button> 
		    		<a href="{{ router.pathFor('index') }}" class="navbar-brand" style="padding-top: 2px"><img src="/images/logo_mini.png" width="77" height="47" alt="KSL.sk logo"></a> 
	    		</div>
	    		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
				  	<ul class="nav navbar-nav">
				  		{% for item in navigation %}
				  			<li{% if navigationSwitch == item.navigationSwitch %} class="active"{% endif %}><a href="{{ item.route ? router.pathFor(item.route) : '#' }}">{{ item.text }}</a></li>
				  		{% endfor%}
				  		
				  		<li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin <span class="caret"></span></a>
				          <ul class="dropdown-menu" role="menu">
				            <li><a href="{{ router.pathFor('nova-sezona') }}">Nová sezóna</a></li>
				            <li><a href="#">Another action</a></li>
				            <li><a href="#">Something else here</a></li>
				            <li class="divider"></li>
				            <li><a href="#">Separated link</a></li>
				            <li class="divider"></li>
				            <li><a href="#">One more separated link</a></li>
				          </ul>
				        </li>
			  		</ul> 
	  			</div>
		  	</div>
		</nav>
		{% endblock %}


		{% block content %}
		{% endblock %}

		{#
		<div class="container">
			<games-list></games-list>
		</div>
		#}



		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="/js/app.js"></script>
		
		{% block scripts %}
		{% endblock %}
	</body>
</html>