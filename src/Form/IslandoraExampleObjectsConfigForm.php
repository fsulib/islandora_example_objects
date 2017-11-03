<?php
/**
 * @file
 * Contains \Drupal\simple\Form\IslandoraExampleObjectsConfigForm.
 */

namespace Drupal\islandora_example_objects\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\islandora_example_objects\includes\RealisticDummyContentWatchdogLog;

class IslandoraExampleObjectsConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'islandora_example_objects_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('islandora_example_objects.settings');
    $node_type_titles = $this->getAllContentTypes();
    
    // Cycle through node types, set default values and add to form. 
    foreach ($node_type_titles as $node_type_machine_name => $node_type_title) {
      // Retrieve value from module settings.
      $current_node_type_number = $config->get($node_type_machine_name);
      $default_number = ($current_node_type_number ? $current_node_type_number : 1);
      
      // Add the field to the form.
      $form[$node_type_machine_name] = array (
        '#type' => 'number',
        '#title' => $node_type_title,
        '#default_value' => $default_number,
      );
    }
    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('islandora_example_objects.settings');
    $node_type_titles = $this->getAllContentTypes();
    
    // Cycle through node types, set default values and add to form. 
    foreach ($node_type_titles as $node_type_machine_name => $node_type_title) {    
     $config->set($node_type_machine_name, $form_state->getValue($node_type_machine_name));
    }
    
    $config->save();
    
    // Create the dummy content
    realistic_dummy_content_api_apply_recipe(new RealisticDummyContentWatchdogLog());
    
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'islandora_example_objects.settings',
    ];
  }
  
  /**
   * @return array of note types (key=machine_name, value=Node Label) 
   */
  protected function getAllContentTypes () {
    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();
    $node_type_titles = array();
    foreach ($node_types as $machine_name => $val) {
      $node_type_titles[$machine_name] = $val->label();
    }
    
    return $node_type_titles;
  }
}
