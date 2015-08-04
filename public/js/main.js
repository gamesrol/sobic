var serverURL = "https://sobic-last-gamesrol.c9.io/public/index.php/api";
var app = angular.module('sobic', ["ngCookies",'ui.bootstrap', 'ngRoute', 'ngAnimate', 'angular-parallax']);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
	
	$locationProvider.html5Mode({
		enabled: true,
  		requireBase: false
	}).hashPrefix = '!';

	/* Es importante que estas líneas siempre esten al final para que funcione el scaffolg. */
	$routeProvider.when('/', {
		templateUrl: 'partials/pages/home.html'
	}).when('/user', {
		templateUrl: 'partials/user/main.html',
		controller: 'UserController'
	}).when('/users/show', {
		templateUrl: 'partials/user/show.html',
		controller: 'ListUsersController'
	}).when('/contact', {
		templateUrl: 'partials/pages/contact.html',
		controller: 'ContactController'
	}).otherwise({
		redirectTo: '/'
	});
}]);