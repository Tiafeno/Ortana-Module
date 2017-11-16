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
  
  public static function getArticles( $catId ) {
    if (false == $catId) return false;
    $results = [];
    $model = JModelLegacy::getInstance( 'Articles', 'ContentModel' );
    $model->setState( 'filter.category_id', (int)$catId ); 
    $articles = $model->getItems();
    foreach ($articles as $article) {
      $currentArticle     = new stdClass();
      $currentArticle->ID = $article->id;
      $currentArticle->title = $article->title;
      $currentArticle->alias = $article->alias;
      $currentArticle->catId = $article->catid;
      $currentArticle->category_title = $article->category_title;
      $currentArticle->category_alias = $article->category_alias;
      $currentArticle->category_route = $article->category_route;
      $currentArticle->images = $article->images;

      array_push( $results, $currentArticle );
    }

    return $results;
  }
	
	public static function getTarifs( $catId ) {
    if (false == $catId) return false;
    JLoader::register( 'FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php' );
    $results = [];
		$model = JModelLegacy::getInstance( 'Articles', 'ContentModel' );
		$model->setState( 'filter.category_id', (int)$catId ); 
    $articles = $model->getItems();
    foreach ( $articles as $article ) {
      $Fields = FieldsHelper::getFields( 'com_content.article', $article, true );
      while (list(, $Field) = each($Fields)) {
        $currentArticle        = new stdClass();
        $currentArticle->field_id    = $Field->id;
        $currentArticle->title = $Field->title;
        $currentArticle->slug  = $Field->name;
        $currentArticle->value = $Field->value;
        $currentArticle->group_title = $Field->group_title;
        $currentArticle->group_id = $Field->group_id;
        $currentArticle->rawValue    = $Field->rawvalue;
        array_push( $results, $currentArticle );
      }
    }

    return $results;
	}
}

