<?php

/**
 * @file
 * Contains employees_entity.page.inc.
 *
 * Page callback for Employees entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Employees entity templates.
 *
 * Default template: employees_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_employees_entity(array &$variables) {
  // Fetch EmployeesEntity Entity Object.
  $employees_entity = $variables['elements']['#employees_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
