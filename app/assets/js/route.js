'use strict'

var routeFormInjectable = angular.module('routeFormInjectable', [ 'ngMaterial'])
  .controller('InscriptionCtrl', ['$scope', 'OServices', 
  function( $scope, OServices ) {
    
  }])
  .controller('FormCtrl', ['$scope', '$location', 'OServices', 'OFactory', 
  function( $scope, $location, OServices, OFactory ) {
    $scope.Articles = {};
    OServices.getArticlesFn()
      .then(function successCallback( response ) {
        console.log( response )
        if ( ! _.isObject( response )) $location.path('/inscription');
        $scope.Articles = response;
      }).catch(function() { console.warn('Error on get article'); });
    
    $scope.sendEmail = function( $event, $form ) {

    };
  }])
  .directive('chooseArticle', ['OServices', '$location', 
    function( OServices, $location) {
      return {
        restrict: "A",
        scope: true,
        link: function(scope, element, attr) {
          var article_id = parseInt(attr.chooseArticle);
          OServices.chooseArticleFn( article_id );
          element.bind('click', function(ev) {
            scope.$apply(function() {
              $location.path( '/inscription/formulaire' );
            })
          })
        }
      }
  }]);