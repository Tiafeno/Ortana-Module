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
    var selectedArticle = null;

    /**
     * @function chooseArticleFn
     * @desc Find article and set this in `selectedArticle` variable
     * @param <article_id> int
     * @return Object
    */
    self.chooseArticleFn = function( article_id ) {
      if ( ! _.isNumber(article_id) || _.isNaN(article_id) ) return false;
      return selectedArticle = _.find( articles, function( _art ) { 
        return parseInt(_art.ID) == article_id; 
      });
    };
    self.getChoosenArticleFn = function() {
      return new Promise(function(resolve, reject) {
        if (_.isNull(selectedArticle)) reject('Error: There are no items to select');
        resolve( selectedArticle );
      });
    };
    self.getArticlesFn = function() { 
      return new Promise(function(resolve, reject) {
        if (_.isEmpty(articles)) reject('Error: Variable article is empty');
        resolve( articles );
      }); 
    };
    self.setArticlesFn = function( art_ ) { return articles = art_; };
    self.getPriceFn = function( article_id ) {
      this._articles = _.find( articles, function( _art ) { 
        return parseInt(_art.ID) == article_id; 
      });
      this.field_price = _.find( this._articles.fields, function( _field ) {
        return  _field.slug == price_slug;
      });
      return this.field_price.value;
    };
  }])
  .controller('OController', ['$scope', 'OFactory', 'OServices', 
    function( $scope, OFactory, OServices ) {
      $scope.Categories = [];
      $scope.Articles = [];
      /* set Articles */
      var articles = [];
      var group_title = (false == Opt.group_title) ? "Inscription" : Opt.group_title.trim();
      articles = _.union( Opt.OArticles );
      _.each(articles, function( article, key ) {
        var _tar = _.filter(Opt.OTarifs, function( tarif ) { 
          return tarif.group_title == group_title;
        });
        article.fields = _.omit( _tar, function( value, key, obj ) { return key == 'ID'; });
      });
      OServices.setArticlesFn( $scope.Articles = articles );
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
  .filter('price', ['OServices', function( OServices ) {
    return function( entry ) {
      var article_id = parseInt( entry );
      return OServices.getPriceFn( article_id );
    }
  }])
  .config(['$routeProvider', function( $routeProvider ) {
    $routeProvider
      .when('/inscription', {
        templateUrl: Opt.OAssets + 'partials/inscription.html',
        controller: 'InscriptionCtrl'
      })
      .when('/inscription/formulaire', {
        templateUrl: Opt.OAssets + 'partials/form.html',
        controller: 'FormCtrl'
      })
      .otherwise({
        redirectTo: '/inscription'
      });
    
  }]);