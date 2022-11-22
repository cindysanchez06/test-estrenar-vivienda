<?php

namespace Drupal\employees\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Employees entity entities.
 *
 * @ingroup employees
 */
interface EmployeesEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Employees entity name.
   *
   * @return string
   *   Name of the Employees entity.
   */
  public function getName();

  /**
   * Sets the Employees entity name.
   *
   * @param string $name
   *   The Employees entity name.
   *
   * @return \Drupal\employees\Entity\EmployeesEntityInterface
   *   The called Employees entity entity.
   */
  public function setName($name);

  /**
   * Gets the Employees entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Employees entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Employees entity creation timestamp.
   *
   * @param int $timestamp
   *   The Employees entity creation timestamp.
   *
   * @return \Drupal\employees\Entity\EmployeesEntityInterface
   *   The called Employees entity entity.
   */
  public function setCreatedTime($timestamp);

}
