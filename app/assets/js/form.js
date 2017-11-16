'use strict'

/* Variable global for module application */
var Opt = Joomla.getOptions('mod_ortana');
var Mail = 'admin@ortana.mg';
var price_slug = "tarifs";

/* Application module */
var ortanaForm = angular.module("OApp", [ "ngRoute", "ngMaterial", "routeFormInjectable" ]);
