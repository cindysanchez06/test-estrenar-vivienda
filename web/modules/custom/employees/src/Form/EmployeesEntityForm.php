<?php

namespace Drupal\employees\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Employees entity edit forms.
 *
 * @ingroup employees
 */
class EmployeesEntityForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;
  /**
   * @var mixed
   */
  private $employeesService;

  public function __construct(EntityRepositoryInterface $entity_repository, EntityTypeBundleInfoInterface $entity_type_bundle_info, TimeInterface $time)
  {
    parent::__construct($entity_repository, $entity_type_bundle_info, $time);
    $this->employeesService = \Drupal::service('employees.employees_service');

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    $instance = parent::create($container);
    $instance->account = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var \Drupal\employees\Entity\EmployeesEntity $entity */
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $position = $form_state->getValue('position')[0]['value'];
    $status = $position == "Administrador";

    $data = [
      'name' => $form_state->getValue('name'),
      'date_birth' => $form_state->getValue('date_birth')[0]['value']->format('Y-m-d'),
      'document_number' => $form_state->getValue('document_number'),
      'position' => $position,
      'status' => $status
    ];
    $result = $this->employeesService->processInformation($data);
    if (!$result['success']) {
      \Drupal::messenger()->addError($result['message']);
    }
    if ($result['success']) {
      \Drupal::messenger()->addStatus($result['message']);
    }
  }

}
