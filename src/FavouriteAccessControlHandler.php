<?php

namespace Drupal\favourite;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Favourite entity.
 *
 * @see \Drupal\favourite\Entity\Favourite.
 */
class FavouriteAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\favourite\Entity\FavouriteInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isValid()) {
          return AccessResult::allowedIfHasPermission($account, 'view invalid favourite entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view valid favourite entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit favourite entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete favourite entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add favourite entities');
  }

}
