<?php

namespace Drupal\employees\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Employees entity entity.
 *
 * @ingroup employees
 *
 * @ContentEntityType(
 *   id = "employees_entity",
 *   label = @Translation("Employees entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\employees\EmployeesEntityListBuilder",
 *     "views_data" = "Drupal\employees\Entity\EmployeesEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\employees\Form\EmployeesEntityForm",
 *       "add" = "Drupal\employees\Form\EmployeesEntityForm",
 *       "edit" = "Drupal\employees\Form\EmployeesEntityForm",
 *       "delete" = "Drupal\employees\Form\EmployeesEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\employees\EmployeesEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\employees\EmployeesEntityAccessControlHandler",
 *   },
 *   base_table = "employees_entity",
 *   translatable = FALSE,
 *   admin_permission = "administer employees entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *     "position" = "position",
 *     "date_birth" = "date_birth",
 *     "document_number" = "document_number"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/employees_entity/{employees_entity}",
 *     "add-form" = "/admin/structure/employees_entity/add",
 *     "edit-form" = "/admin/structure/employees_entity/{employees_entity}/edit",
 *     "delete-form" = "/admin/structure/employees_entity/{employees_entity}/delete",
 *     "collection" = "/admin/structure/employees_entity",
 *   },
 *   field_ui_base_route = "employees_entity.settings"
 * )
 */
class EmployeesEntity extends ContentEntityBase implements EmployeesEntityInterface
{

    use EntityChangedTrait;
    use EntityPublishedTrait;

    /**
     * {@inheritdoc}
     */
    public static function preCreate(EntityStorageInterface $storage_controller, array &$values)
    {
        parent::preCreate($storage_controller, $values);
        $values += [
            'user_id' => \Drupal::currentUser()->id(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->get('name')->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->set('name', $name);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedTime()
    {
        return $this->get('created')->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedTime($timestamp)
    {
        $this->set('created', $timestamp);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner()
    {
        return $this->get('user_id')->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwnerId()
    {
        return $this->get('user_id')->target_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwnerId($uid)
    {
        $this->set('user_id', $uid);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner(UserInterface $account)
    {
        $this->set('user_id', $account->id());
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition($position): EmployeesEntity
    {
        $this->set('position', $position);
        return $this;
    }

    public function setDateBirth($dateBirth): EmployeesEntity
    {
        $dateBirth = strtotime($dateBirth);
        $this->set('date_birth', $dateBirth);
        return $this;
    }

    public function setStatus($status)
    {
      $this->set('status', $status);
      return $this;
    }

    public function setDocumentNumber($documentNumber): EmployeesEntity
    {
        $this->set('document_number', $documentNumber);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields = parent::baseFieldDefinitions($entity_type);

        // Add the published field.
        $fields += static::publishedBaseFieldDefinitions($entity_type);

        $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Authored by'))
            ->setDescription(t('The user ID of author of the Employees entity entity.'))
            ->setRevisionable(TRUE)
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setDisplayOptions('view', [
                'label' => 'hidden',
                'type' => 'author',
                'weight' => 0,
            ])
            ->setDisplayOptions('form', [
                'type' => 'entity_reference_autocomplete',
                'region' => 'hidden',
                'weight' => 5,
                'settings' => [
                    'match_operator' => 'CONTAINS',
                    'size' => '60',
                    'autocomplete_type' => 'tags',
                    'placeholder' => '',
                ],
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Name'))
            ->setDescription(t('The name of the Employee'))
            ->setRevisionable(TRUE)
            ->setSettings([
                'max_length' => 50,
                'text_processing' => 0,
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'string',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textfield',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE)
            ->setRequired(TRUE);

        $fields['date_birth'] = BaseFieldDefinition::create('datetime')
            ->setLabel(t('Date of Birth'))
            ->setDescription(t('The Date of Birth of the Employee'))
            ->setRevisionable(TRUE)
            ->setSettings([
                'datetime_type' => 'date',
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'datetime_default',
                'settings' => [
                    'format_type' => 'medium',
                ],
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'datetime_default',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE)
            ->setRequired(TRUE);

        $fields['document_number'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Document Number'))
            ->setDescription(t('The document number of the Employee'))
            ->setRevisionable(TRUE)
            ->setSettings([
                'max_length' => 15,
                'text_processing' => 0,
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'number',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'number',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE)
            ->setRequired(TRUE);

        $fields['position'] = BaseFieldDefinition::create('list_string')
            ->setLabel(t('Position'))
            ->setDescription(t('The position of the Employee'))
            ->setRevisionable(False)
            ->setSettings([
                'max_length' => 50,
                'text_processing' => 0,
                'allowed_values' => [
                    'Administrador' => 'Administrador',
                    'Webmaster' => 'Webmaster',
                    'Desarrollador' => 'Desarrollador',
                ],
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'visible',
                'type' => 'list_default',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'options_select',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE)
            ->setRequired(TRUE);

        $fields['status']->setDescription(t('The status of the Employee'))
            ->setDefaultValue(False)
            ->setDisplayOptions('view', [
                'label' => 'hidden',
                'type' => 'hidden',
                'weight' => 2,
                'region' => 'hidden',
            ])
            ->setDisplayOptions('form', [
                'type' => 'hidden',
                'region' => 'hidden',
                'weight' => 2,
            ])
            ->setDisplayConfigurable('view', TRUE)
            ->setDisplayConfigurable('form', TRUE);

        $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'))
            ->setDescription(t('The time that the entity was created.'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'))
            ->setDescription(t('The time that the entity was last edited.'));

        return $fields;
    }

}
