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

    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#default_value' => $config->get('islandora_example_objects.email'),
      '#required' => TRUE,
    );

    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();
    $node_type_titles = array();
    foreach ($node_types as $machine_name => $val) {
      $node_type_titles[$machine_name] = $val->label();
    }

    $form['node_types'] = array(
      '#type' => 'checkboxes',
      '#title' => $this->t('Node Types'),
      '#options' => $node_type_titles,
      '#default_value' => $config->get('islandora_example_objects.node_types'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('islandora_example_objects.settings');
    $config->set('islandora_example_objects.email', $form_state->getValue('email'));
    $config->set('islandora_example_objects.node_types', $form_state->getValue('node_types'));
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
}
