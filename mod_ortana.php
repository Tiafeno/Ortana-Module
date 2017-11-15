<?php
/*
  Module name: ORTANA subscription
  Module URI: https//github.com/Tiafeno/mod_ortana
  Description: Module joomla, subscription
  Author: TIAFENO Finel
  Author URI: http://www.falicrea.com
*/
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';

$currentPageUrl = JUri::getInstance(); 
$client = $params->get('client', '1');
$catId = $params->get('catId');
$tarifs = modOrtanaHelper::getContentTarifs( $catId );
$articles = modOrtanaHelper::getArticles( $catId );

JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addScriptOptions('mod_ortana', [
  'OAssets' => JUri::base() . 'modules/mod_ortana/app/assets/',
  'OCategoryId' => (int)$catId,
  'OTarifs' => $tarifs,
  'OArticles' => $articles,
  'ajax_url' => $currentPageUrl->toString()
]);
/* underscorejs librarie */
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/underscore/underscore-min.js');
/* angularjs librarie */
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular/angular.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-route/angular-route.js');
/* application */
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/form.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/route.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/form.controller.js');

require JModuleHelper::getLayoutPath( "mod_ortana" );