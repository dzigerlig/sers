'use strict';

angular.module('sers.controllers').controller('OverviewController', [ '$scope', 'eventService', '$modal',
    function($scope, eventService, $modal) {

        $scope.events = {};

        var getEvents = function() {
            eventService.query(function(events) {
                 $scope.events = events;
				 angular.forEach(events, function(event) {
					 event.postDate = moment(event.postDate).locale("de").format("DD.MM.YYYY");
					 event.date_start = moment(event.date_start).locale("de").format("DD.MM.YYYY");
					 event.date_end = moment(event.date_end).locale("de").format("DD.MM.YYYY");
					 event.registration_until = moment(event.registration_until).locale("de").format("DD.MM.YYYY");
				 });
            });
        };

        getEvents();

        $scope.openParticipateModal = function(eventObject) {
            var modalInstance = $modal.open({
                backdrop: 'static',
                templateUrl: 'views/participation-modal.html',
                controller: 'ParticipationController',
                resolve: {
                    event: function() {
                        return eventObject;
                    }
            }});

            modalInstance.result.then(function() {
                getEvents();
	        }, function() {
	             alert("error");
	        });
        };

        $scope.openParticipantsModal = function(eventObject) {
            var modalInstance = $modal.open({
                backdrop: 'static',
                templateUrl: 'views/participants-modal.html',
                controller: 'ParticipantsModalController',
                resolve: {
                    event: function() {
                        return eventObject;
                    }
            }});            
        }
    }
]);

angular.module('sers.controllers').controller('ParticipationController', ['$scope', '$modalInstance', '$http', 'event', 'REST_URL',
    function($scope, $modalInstance, $http, event, REST_URL) {

        $scope.participation = {};

        $scope.event = event;
        
        if (event.freeSlotsSkydive == 0) {
        	$scope.participation.pax = true;
        }

        $scope.participate = function() {
            $scope.participation.eventId = event.eventId;
            if (!$scope.participation.pax) {
                $scope.participation.pax = false;
            }
            $http.post(REST_URL + "events/" + event.eventId + "/participants", $scope.participation).success(function (data) {
                $modalInstance.close();
            }).error(function (data) {
                alert("error");
            });
        };
        
        $scope.cancel = function() {
            $modalInstance.dismiss();
        };

    }
]);

angular.module('sers.controllers').controller('ParticipantsModalController', ['$scope', '$modalInstance', '$http', 'event', 'REST_URL',
    function($scope, $modalInstance, $http, event, REST_URL) {

        $scope.event = event;
        
        $scope.abmelden = {};
        
        $scope.showAbmelden = function(firstName, lastName, id) {
        	$scope.abmelden.show = true;
        	$scope.abmelden.participantsId = id;
        	$scope.abmelden.firstName = firstName;
        	$scope.abmelden.lastName = lastName;
        };
        
        $scope.abmelden = function() {
        	$http.delete(REST_URL + 'events/' + event.eventId + '/participants/' + $scope.abmelden.participantsId, {deleteCode: $scope.abmelden.code }).success(function () {
        		alert("gelöscht");
        	})
        };
        
        $scope.abmeldenCancel = function() {
        	$scope.abmelden.show = false;
        };

        $http.get(REST_URL + 'events/' + event.eventId + '/participants').success(function(data) {
            $scope.participants = data;
        });
        
        $scope.close = function() {
            $modalInstance.dismiss();
        };
    }
]);