<?php

/**
 * @file
 * Contains a recipe for generating realistic Islandora dummy content.
 * 
 * Note: realistic_dummy_content and devel_generate modules must be enabled.
 *
 * To create sample content, overwrite the file installed by default in
 * PATH_TO_MODULES/realistic_dummy_content/realistic_dummy_content/recipe/
 * with this one and run 'drush generate-realistic'. 
 */

// Required as of the 2.x branch.
use Drupal\realistic_dummy_content_api\includes\RealisticDummyContentRecipe;

/**
 * This recipe creates 1 Basic Page, 2 Islandora Collection and 8 Islandora Image.
 */
// @codingStandardsIgnoreStart
// We cannot Make this file conform to coding standards because existing
// projects might have used this as an example and we need to continue
// supporting this technique for defining recipes.
class islandora_example_objects_realistic_dummy_content_recipe extends RealisticDummyContentRecipe {

  /**
   * {@inheritdoc}
   */
  public function _Run_() {
    // Create content
    $this->NewEntities('node', 'page', 1, array('kill' => TRUE));
    $this->NewEntities('node', 'islandora_collection', 4, array('kill' => TRUE));
    $this->NewEntities('node', 'islandora_image', 8, array('kill' => TRUE));
  }
// @codingStandardsIgnoreEnd

}
