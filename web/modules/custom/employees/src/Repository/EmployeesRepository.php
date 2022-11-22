<?php

namespace Drupal\employees\Repository;

use Drupal\Core\Database\Database;
use Drupal\employees\Entity\EmployeesEntity;

class EmployeesRepository extends Database
{
  private $connection;

  public function __construct()
  {
    $this->connection = \Drupal::database();
  }

  /**
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function add(array $data)
  {
    $employee = EmployeesEntity::create();
    $employee->setName($data['name']);
    $employee->setDateBirth($data['date_birth']);
    $employee->setPosition($data['position']);
    $employee->setDocumentNumber($data['document_number']);
    $employee->setOwnerId($data['user_id']);
    $employee->save();
    return $employee;
  }
}
