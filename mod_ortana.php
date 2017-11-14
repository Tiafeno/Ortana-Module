<?php
// No direct access
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';

$client = $params->get('client', '1');
$catId = $params->get('catId');
$Tarifs = modOrtanaHelper::getContentTarifs( $catId );

JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addScriptOptions('mod_ortana', [
  'OAssets' => JUri::base() . 'modules/mod_ortana/app/assets/',
  'OCategoryId' => (int)$catId,
  'OTarifs' => $Tarifs
]);
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular/angular.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/lib/angular-route/angular-route.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/form.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/route.js');
$document->addScript( JUri::base() . 'modules/mod_ortana/app/assets/js/form.controller.js');

require JModuleHelper::getLayoutPath( "mod_ortana" );