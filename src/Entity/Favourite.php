<?php

namespace Drupal\favourite\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Favourite entity.
 *
 * @ingroup favourite
 *
 * @ContentEntityType(
 *   id = "favourite",
 *   label = @Translation("Favourite"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\favourite\FavouriteListBuilder",
 *     "views_data" = "Drupal\favourite\Entity\FavouriteViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\favourite\Form\FavouriteForm",
 *       "add" = "Drupal\favourite\Form\FavouriteForm",
 *       "edit" = "Drupal\favourite\Form\FavouriteForm",
 *       "delete" = "Drupal\favourite\Form\FavouriteDeleteForm",
 *     },
 *     "access" = "Drupal\favourite\FavouriteAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\favourite\FavouriteHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "favourite",
 *   admin_permission = "administer favourite entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/favourite/favourite/{favourite}",
 *     "add-form" = "/admin/favourite/favourite/add",
 *     "edit-form" = "/admin/favourite/favourite/{favourite}/edit",
 *     "delete-form" = "/admin/favourite/favourite/{favourite}/delete",
 *     "collection" = "/admin/favourite/favourite",
 *   },
 *   field_ui_base_route = "favourite.settings"
 * )
 */
class Favourite extends ContentEntityBase implements FavouriteInterface
{

    use EntityChangedTrait;

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
    public function isValid()
    {
        return (bool)$this->getEntityKey('status');
    }

    /**
     * {@inheritdoc}
     */
    public function setValid($valid)
    {
        $this->set('status', $valid ? TRUE : FALSE);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields = parent::baseFieldDefinitions($entity_type);

        $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('所属用户'))
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setDisplayOptions('view', [
                'label' => 'inline',
                'type' => 'author'
            ])
            ->setDisplayOptions('form', [
                'type' => 'entity_reference_autocomplete',
                'settings' => [
                    'match_operator' => 'CONTAINS',
                    'size' => '60',
                    'autocomplete_type' => 'tags',
                    'placeholder' => '',
                ],
            ]);

        $fields['name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('名称'))
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'string'
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textfield'
            ]);

        $fields['favourite'] = BaseFieldDefinition::create('dynamic_entity_reference')
            ->setLabel(t('喜爱的事物'))
            ->setDisplayOptions('view', [
                'type' => 'dynamic_entity_reference_label'
            ]);

        $fields['status'] = BaseFieldDefinition::create('boolean')
            ->setLabel(t('是否有效'))
            ->setDefaultValue(TRUE)
            ->setDisplayOptions('form', [
                'type' => 'boolean_checkbox'
            ]);

        $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'))
            ->setDescription(t('The time that the entity was created.'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'))
            ->setDescription(t('The time that the entity was last edited.'));

        return $fields;
    }

}
