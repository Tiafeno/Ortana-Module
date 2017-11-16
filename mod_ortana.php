<?php
/*
  Module name: ORTANA subscription
  Module URI: https//github.com/Tiafeno/mod_ortana
  Description: Module joomla, subscription
  Author: TIAFENO Finel
  Author Mail: tiafenofnel@gmail.com
  Author URI: http://www.falicrea.com
*/
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';

$application = JFactory::getApplication();
$currentPageUrl = JUri::getInstance(); 

$catId = $params->get('catId', false);
$mailTo = $params->get('mail', false);
$group_title = $params->get('group_title', false);

$tarifs = modOrtanaHelper::getTarifs( $catId );
$articles = modOrtanaHelper::getArticles( $catId );

if (false == $catId)
  jError::raiseWarning(100, 'Veuillez configurer les paramètres du module mod_ortana - @Finel');

/* Include native jquery libaries */
JHtml::_('jquery.framework');

$document = JFactory::getDocument();
$document->addScriptOptions('mod_ortana', [
  'OAssets' => JUri::base() . 'modules/mod_ortana/app/assets/',
  'OCategoryId' => (int)$catId,
  'OTarifs' => $tarifs,
  'OArticles' => $articles,
  'ajax_url' => $currentPageUrl->toString(),
  'group_title' => $group_title
]);

/* underscorejs librarie */
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/underscore/underscore-min.js');
/* Angularjs librarie */
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular/angular.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-route/angular-route.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-animate/angular-animate.min.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-messages/angular-messages.min.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-aria/angular-aria.min.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-sanitize/angular-sanitize.min.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-material/angular-material.min.js');

$document->addStyleSheet( 'https://fonts.googleapis.com/icon?family=Material+Icons' );
$document->addStyleSheet( JUri::base() . 'modules/mod_ortana/app/lib/angular-material/angular-material.css' );
/* Application angulajs files */
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/route.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/form.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/form.controller.js');

require JModuleHelper::getLayoutPath( "mod_ortana" );