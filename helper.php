<?php

class modOrtanaHelper {

  /* @function getCategoriesAjax
  ** This function get all categories
  ** @params void
  ** @return array
  */
  public static function getCategoriesAjax() {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    
    $query->select($db->quoteName(array('title', 'id')))
          ->from($db->quoteName('#__categories'))
          ->where($db->quoteName('parent_id') . ' != 0')
          ->where($db->quoteName('extension') . ' = ' . $db->quote('com_content'));
    
    $db->setQuery($query);
    return $db->loadObjectList();
  }
	
}

