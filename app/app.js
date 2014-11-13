'use strict'; 

angular.module('sers', [ 
    'ui.router', 
    'ngResource',
    'ui.bootstrap.modal',
    'ui.bootstrap',
    'sers.controllers',
    'sers.services',
    'sers.routes']).constant('REST_URL', '/sers/services/'); 

angular.module('sers.routes', []); 
angular.module('sers.services', []);
angular.module('sers.controllers', []); 