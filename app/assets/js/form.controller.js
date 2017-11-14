'use strict'
ortanaForm
  .factory('OFactory', ['$http', '$q', function( $http, $q) {
    return {
      getClients: function() {
        return $http.get( Opt.ajax_url , {
          params : {
            option: 'com_ajax',
            module: 'ortana',
            method: 'getClients',
            format: 'json'
          }
        });
      },
      getCategories: function() {
        return $http.get( Opt.ajax_url, {
          params: {
            option: 'com_ajax',
            module: 'ortana',
            method: 'getCategories',
            format: 'json'
          }
        })
      },
      formHttp: function( form ) {
        return $http({
          url: Opt.ajax_url,
          method: "POST",
          headers: { 'Content-Type': undefined },
          data: form
        });
      }
    }
  }])
  .controller('OController', ['$scope', 'OFactory', function( $scope, OFactory) {
    $scope.Categories = [];
    
    var OForm = new FormData();
    OForm.append('option', 'com_ajax');
    OForm.append('module', 'ortana');
    OForm.append('method', 'getCategories');
    OForm.append('format', 'json');
    OFactory.formHttp( OForm )
      .then( results => {
        console.log(results.data);
      })
  }]);