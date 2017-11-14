'use strict'

ortanaForm
  .config(['$routeProvider', function( $routeProvider ) {
    $routeProvider
      .when('/inscription', {
        templateUrl: Opt.OAssets + 'partials/inscription.html',
        controller: 'InscriptionCtrl'
      })
      .otherwise({
        redirectTo: '/inscription'
      });
    
  }]);

var routeForm = angular.module('routeForm', [])
  .controller('InscriptionCtrl' ['$scope', function( $scope ) {

  }]);