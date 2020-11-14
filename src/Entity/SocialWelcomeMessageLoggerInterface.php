<?php

namespace Drupal\social_welcome_message\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Welcome Message Logs entities.
 *
 * @ingroup social_welcome_message
 */
interface SocialWelcomeMessageLoggerInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Welcome Message Logs name.
   *
   * @return string
   *   Name of the Welcome Message Logs.
   */
  public function getName();

  /**
   * Sets the Welcome Message Logs name.
   *
   * @param string $name
   *   The Welcome Message Logs name.
   *
   * @return \Drupal\social_welcome_message\Entity\SocialWelcomeMessageLoggerInterface
   *   The called Welcome Message Logs entity.
   */
  public function setName($name);

  /**
   * Gets the Welcome Message Logs creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Welcome Message Logs.
   */
  public function getCreatedTime();

  /**
   * Sets the Welcome Message Logs creation timestamp.
   *
   * @param int $timestamp
   *   The Welcome Message Logs creation timestamp.
   *
   * @return \Drupal\social_welcome_message\Entity\SocialWelcomeMessageLoggerInterface
   *   The called Welcome Message Logs entity.
   */
  public function setCreatedTime($timestamp);


  public function getGroup();

  public function setGroup($group);

}
