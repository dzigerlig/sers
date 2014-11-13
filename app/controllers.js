'use strict';

angular.module('sers.controllers').controller('OverviewController', [ '$scope', 'eventService', '$modal',
    function($scope, eventService, $modal) {

        $scope.events = {};

        var getEvents = function() {
            eventService.query(function(events) {
                 $scope.events = events;
                 console.log(events);
//				 angular.forEach(events, function(event) {
//					var oneDay = 24*60*60*1000;
//				 	var date = new Date(event.registration_until);
//					var dateNow = new Date();
//					event.remainingRegistrationDays = Math.round((date.getTime()-dateNow.getTime())/(oneDay));
//					event.remainingRegistrationDays = event.remainingRegistrationDays < 0 ? 0 : event.remainingRegistrationDays;
//					event.availableSlots = parseInt(event.slotsSkydive) + parseInt(event.slotsPax);
//				 });
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

            modalInstance.result.then(function () {
                reservingQuarterService.delete(reservingQuarterObject.id, reservingQuarterObject.version).success(
                    function() {
                        getEvents();
                    });
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

        $scope.participate = function() {
            $scope.participation.eventId = event.eventId;
            if (!$scope.participation.pax) {
                $scope.participation.pax = false;
            }
            $http.post(REST_URL + "events/" + event.eventId + "/participants", $scope.participation).success(function (data) {
                alert("added to event");
                $modalInstance.dismiss();
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

    

        $http.get(REST_URL + 'events/' + event.eventId + '/participants').success(function(data) {
            $scope.participants = data;
        });
        
        $scope.close = function() {
            $modalInstance.dismiss();
        };

    }
]);