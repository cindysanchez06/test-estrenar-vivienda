<?php

namespace Drupal\employees;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Employees entity entity.
 *
 * @see \Drupal\employees\Entity\EmployeesEntity.
 */
class EmployeesEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\employees\Entity\EmployeesEntityInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished employees entity entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published employees entity entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit employees entity entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete employees entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add employees entity entities');
  }


}
