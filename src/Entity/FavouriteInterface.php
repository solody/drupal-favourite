<?php

namespace Drupal\favourite\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Favourite entities.
 *
 * @ingroup favourite
 */
interface FavouriteInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Favourite name.
   *
   * @return string
   *   Name of the Favourite.
   */
  public function getName();

  /**
   * Sets the Favourite name.
   *
   * @param string $name
   *   The Favourite name.
   *
   * @return \Drupal\favourite\Entity\FavouriteInterface
   *   The called Favourite entity.
   */
  public function setName($name);

  /**
   * Gets the Favourite creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Favourite.
   */
  public function getCreatedTime();

  /**
   * Sets the Favourite creation timestamp.
   *
   * @param int $timestamp
   *   The Favourite creation timestamp.
   *
   * @return \Drupal\favourite\Entity\FavouriteInterface
   *   The called Favourite entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Favourite valid status indicator.
   *
   * Unvalid Favourite are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Favourite is valid.
   */
  public function isValid();

  /**
   * Sets the valid status of a Favourite.
   *
   * @param bool $valid
   *   TRUE to set this Favourite to valid, FALSE to set it to unvalid.
   *
   * @return \Drupal\favourite\Entity\FavouriteInterface
   *   The called Favourite entity.
   */
  public function setValid($valid);

}
