<?php

namespace Drupal\social_welcome_message;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Welcome Message Logs entities.
 *
 * @ingroup social_welcome_message
 */
class SocialWelcomeMessageLoggerListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Welcome Message Logs ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\social_welcome_message\Entity\SocialWelcomeMessageLogger $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.social_welcome_message_logger.edit_form',
      ['social_welcome_message_logger' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
