<?php

class modOrtanaHelper {
  public static function getForm( $args ) {
    return 'This is a content form';
  }

  public static function getClient( $contact ) {
    // Obtain a database connection
    $db = JFactory::getDbo();
    // Retrieve the shout
    $query = $db->getQuery(true)
                ->select($db->quoteName('client'))
                ->from($db->quoteName('ortana_clients'))
                ->where('contact = ' . $db->Quote( $contact ));
    // Prepare the query
    $db->setQuery($query);
    // Load the row.
    $result = $db->loadResult();
    // Return the Hello
    return $result;
	}
	
  public static function getClientsAjax() {
    // Obtain a database connection
    $db = JFactory::getDbo();
    // Retrieve the shout
    $query = $db->getQuery(true)
                ->select($db->quoteName('client'))
                ->from($db->quoteName('ortana_clients'));
    // Prepare the query
    $db->setQuery($query);
    // Load the row.
    $result = $db->loadResult();
    // Return the Hello
    return $result;
  }

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
	
	public static function getTarifs() {
		$article = JTable::getInstance("content"); 
		$id = JFactory::getApplication()->input->getInt('id');
		//$article->load($id); // Get Article 
		
		$cat = JTable::getInstance('category');
		$cat->load($id);
		return $cat;
		
	}
	
	public static function getContentTarifs( $catId ) {
    JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
    $results = [];
		$model = JModelLegacy::getInstance('Articles', 'ContentModel');
		$model->setState('filter.category_id', (int)$catId); // Set category ID here
    $articles = $model->getItems();
    foreach ( $articles as $article ) {
      $articleFields = [];
      $Fields = FieldsHelper::getFields('com_content.article', $article, true);
      while (list(, $Field) = each($Fields)) {
        $currentArticle = new stdClass();
        $currentArticle->ID = $Field->id;
        $currentArticle->title = $Field->title;
        $currentArticle->slug = $Field->name; // rename
        $currentArticle->group_title = $Field->group_title;
        $currentArticle->value = $Field->value;
        $currentArticle->rawValue = $Field->rawvalue;
        array_push( $articleFields, $currentArticle );
      }
      array_push( $results, $articleFields );
    }

    return $results;
	}
}

