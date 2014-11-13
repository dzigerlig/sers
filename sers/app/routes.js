'use strict';

angular.module('sers.routes').config([
    '$stateProvider',
    '$urlRouterProvider',
    function ($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise("/overview");

        $stateProvider
        	// Overview Reserving:
	        .state('overview', {
	            url: '/overview',
	            templateUrl: 'views/overview.html',
	            controller: 'OverviewController',
	        })
	        // Import:
	        // TODO
	        
	        // Reserving Classes
	        //.state('reserving-class-overview', {
	        	//url: '/reserving-class-overview',
	        	//templateUrl: 'views/reserving_class/reserving-class-overview.html'
	        //})
	        
	        // Test
    }
]);