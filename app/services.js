'use strict';

angular.module('sers.services').service('eventService', ['$resource', 'REST_URL',
      function ($resource, REST_URL) {
	  		return $resource(REST_URL + "events",{}, {
				'query': {
					method: 'GET',
					isArray: true	
				}	
			}
			);
}                                                       
]);

angular.module('sers.services').service('participantService', ['$resource', 'REST_URL',
      function ($resource, REST_URL) {
	  		return $resource(REST_URL + "participants");
}                                                       
]);