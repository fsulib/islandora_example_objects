<?php

/**
 * @file
 * Contains a recipe for generating realistic Islandora dummy content.
 * 
 * Note: This file is edited using the configuration form for the module
 * DO NOT EDIT DIRECTLY
 *  
 */

// Required as of the 2.x branch.
use Drupal\realistic_dummy_content_api\includes\RealisticDummyContentRecipe;

/**
 * This recipe creates nodes based on the data from this module's configuration.
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
    
    // Load the module configuration and figure out how many nodes to create.
    $config = \Drupal::config('islandora_example_objects.settings');
    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();
    $node_type_titles = array();
    foreach ($node_types as $machine_name => $val) {
      $node_type_titles[$machine_name] = $val->label();
    }
    
    // Cycle through node types, set default values and create content. 
    foreach ($node_type_titles as $node_type_machine_name => $node_type_title) {
      // Retrieve value from module settings.
      $current_node_type_number = $config->get($node_type_machine_name);
      $default_number = ($current_node_type_number ? $current_node_type_number : 1);
      
      // Create the dummy content.
      $this->NewEntities('node', $node_type_machine_name, $default_number, array('kill' => FALSE));
    }
  }
// @codingStandardsIgnoreEnd

}
