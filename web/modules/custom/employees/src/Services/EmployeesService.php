<?php

namespace Drupal\employees\Services;


use Drupal\employees\Repository\EmployeesRepository;

class EmployeesService
{
  protected EmployeesRepository $employeesRepository;

  public function __construct(EmployeesRepository $employeesRepository)
  {
    $this->employeesRepository = $employeesRepository;
  }

  public function processInformation($data)
  {
    $success = false;
    $tx = \Drupal::database()->startTransaction();
    try {
      $data['user_id'] = \Drupal::currentUser()->id();
      $employee = $this->employeesRepository->add($data);
      $result = [
        'message' => "Empleado creado con éxito",
        'success' => true,
        'employee' => $employee
      ];
    } catch (\ErrorException $exception) {
      $tx->rollBack();
      \Drupal::messenger()->addError($exception->getMessage());
      $result = [
        'message' => $exception->getMessage(),
        'success' => $success
      ];
    } catch (\Exception $exception) {
      $tx->rollBack();
      \Drupal::messenger()->addError($exception->getMessage());
      $result = [
        'message' => $exception->getMessage(),
        'success' => $success
      ];
    }
    return $result;
  }
}
