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

      /**
      ** @function formHttp
      ** @param: form <FormData>
      ** @return: Promise for http POST action
      **/
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
  .service('OServices', ['$http', '$q', function( $http, $q ) {
    var self = this;
    var articles = [];
    var selectedArticle = [];

    self.chooseArticleFn = function( article_id ) {

    };
    self.getArticlesFn = function() { return articles; };
    self.setArticlesFn = function( art_ ) {
      return articles = art_;
    };
  }])
  .controller('OController', ['$scope', 'OFactory', 'OServices', function( $scope, OFactory, OServices) {
    $scope.Categories = [];
    $scope.Articles = [];
    /* set Articles */
    var articles = [];
    articles = _.union( Opt.OArticles );
    _.each(articles, function( article, key ) {
      // TODO: group_title review
      article.fields = _.find(Opt.OTarifs, function( tarif ) { return parseInt( tarif.ID) == parseInt( article.ID ); });
    });
    OServices.setArticlesFn( $scope.Articles = articles );
    console.log( $scope.Articles );
    /* get Categories */
    var OForm = new FormData();
    OForm.append('option', 'com_ajax');
    OForm.append('module', 'ortana');
    OForm.append('method', 'getCategories');
    OForm.append('format', 'json');
    OFactory.formHttp( OForm )
      .then( function successCallback( results ) {
        var request = results.data;
        if (request.success)
          $scope.Categories = request.data;
      });
  }])
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