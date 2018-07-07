/*global angular*/

(function(angular){
	var Referee = angular.module("referee", ["ngRoute"]);


	Referee.config(["$locationProvider", "$routeProvider", function config($locationProvider, $routeProvider) {
		$locationProvider.hashPrefix("!");

		$routeProvider.when("/phones", { template: "<phone-list></phone-list>"});
	}]);


	Referee.filter('getDateProperty', function() {
	    return function(input) {
	    	return input.date;
	    };
	  });


	Referee.controller("MainController", function(){
		this.games = window.matches;

		this.test = "TOTO JE TEST";
	});

	Referee.directive("gamesList", function(){
		return {
			restrict: "E",
			templateUrl: "template/gamesList.html",
			controller: function() {
				this.sortGames = function(game) {
					return game.date;
				}
			},
			controllerAs: "list"
		}
	});
}(angular));


var matches = [ ];
var teams = ["4FUN", "BlackStreet", "Banany", "Dzungele", "TydamBoyz", "BadBoyz"];
for(var i = 0; i < 20; i++) {
	var homeTeam = teams[ Math.round(Math.random() * (teams.length-1)) ];
	var awayTeam = teams[ Math.round(Math.random() * (teams.length-1)) ];
	while(homeTeam == awayTeam)
		awayTeam = teams[ Math.round(Math.random() * (teams.length-1)) ];

	var date = Date.now() + Math.round(1000000000 * Math.random() * (Math.random() < 0.5 ? -1 : 1));
	//var date = i * 100000000;

	matches.push({
		"id": i,
		"homeTeam": homeTeam,
		"awayTeam": awayTeam,
		"date": date,
		"playground": 1
	});
}