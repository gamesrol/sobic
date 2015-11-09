var serverURL = "/public/index.php/api";
var app = angular.module('sobic', ["ngCookies",'ui.bootstrap', 'ngRoute', 'ngAnimate', 'angular-parallax', 'ngFileUpload', 'pascalprecht.translate']);

app.config(['$routeProvider', '$locationProvider', '$translateProvider', function($routeProvider, $locationProvider, $translateProvider) {
	
	$locationProvider.html5Mode({
		enabled: true,
  		requireBase: false
	}).hashPrefix = '!';
	
	$translateProvider
		.translations('en', EN_en )
		.translations('es', ES_es );
	
	$translateProvider.useSanitizeValueStrategy(null);
	
	$routeProvider.when('/', {
		templateUrl: 'partials/pages/home.html',
		controller: 'PageMainController'
	}).when('/users/show', {
		templateUrl: 'partials/user/userShow.html',
		controller: 'ListUsersController'
	}).when('/profile/password', {
		templateUrl: 'partials/user/passChange.html',
		controller: 'ChangePassController'
	}).when('/profile/recover', {
		templateUrl: 'partials/user/recover.html',
		controller: 'RecoverController'
	}).when('/recovery/:key_token', {
		templateUrl: 'partials/user/recovery.html',
		controller: 'RecoveryController'
	}).when('/profile', {
		templateUrl: 'partials/profile/profileShow.html',
		controller: 'ProfileController'
	}).when('/profile/form', {
		templateUrl: 'partials/profile/profileForm.html',
		controller: 'ProfileFormController'
	/* It is important to respect these comments to generate smooth scaffold. */
	/** Scaffold main.js **/
	}).otherwise({
		redirectTo: '/'
	});
}]);
