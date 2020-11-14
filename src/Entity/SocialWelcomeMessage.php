<?php

namespace Drupal\social_welcome_message\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Welcome Message entity.
 *
 * @ConfigEntityType(
 *   id = "social_welcome_message",
 *   label = @Translation("Welcome Message"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\social_welcome_message\SocialWelcomeMessageListBuilder",
 *     "form" = {
 *       "add" = "Drupal\social_welcome_message\Form\SocialWelcomeMessageForm",
 *       "edit" = "Drupal\social_welcome_message\Form\SocialWelcomeMessageForm",
 *       "delete" = "Drupal\social_welcome_message\Form\SocialWelcomeMessageDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\social_welcome_message\SocialWelcomeMessageHtmlRouteProvider",
 *     },
 * "access" = "Drupal\social_welcome_message\SocialWelcomeMessageAccessControlHandler",
 *   },
 *   config_prefix = "social_welcome_message",
 *   admin_permission = "manage social welcome messages",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/social_welcome_message/{social_welcome_message}",
 *     "add-form" = "/group/{group}/social_welcome_message/add",
 *     "edit-form" = "/admin/social_welcome_message/{social_welcome_message}/edit",
 *     "delete-form" = "/admin/social_welcome_message/{social_welcome_message}/delete",
 *   }
 * )
 */
class SocialWelcomeMessage extends ConfigEntityBase implements SocialWelcomeMessageInterface {

  /**
   * The Welcome Message ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Welcome Message label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Welcome Message subject.
   *
   * @var string
   */
  protected $subject;

  /**
   * The Welcome Message body.
   *
   * @var array
   */
  protected $body;

    /**
   * The Welcome Message body existing.
   *
   * @var array
   */
  protected $bodyExisting;

  /**
   * The Welcome Message group.
   *
   * @var string
   */
  protected $group;


  /**
   * {@inheritdoc}
   */
  public function getSubject() {
    return $this->subject;
  }

  /**
   * {@inheritdoc}
   */
  public function setSubject(string $subject) {
    $this->subject = $subject;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getBody() {
    return $this->body;
  }

  /**
   * {@inheritdoc}
   */
  public function setBody(array $body) {
    $this->body = $body;
    return $this;
  }

    /**
   * {@inheritdoc}
   */
  public function getBodyExisting() {
    return $this->body_existing;
  }

  /**
   * {@inheritdoc}
   */
  public function setBodyExisting(array $body) {
    $this->body_existing = $body;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getGroup() {
    return $this->group;
  }

  /**
   * {@inheritdoc}
   */
  public function setGroup(string $group) {
    $this->group = $group;
    return $this;
  }

}
