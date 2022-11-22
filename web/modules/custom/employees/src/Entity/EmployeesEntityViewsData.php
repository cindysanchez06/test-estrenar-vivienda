<?php

namespace Drupal\employees\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Employees entity entities.
 */
class EmployeesEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
