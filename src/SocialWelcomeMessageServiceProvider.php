<?php

namespace Drupal\social_welcome_message;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

// @note: You only need Reference, if you want to change service arguments.
use Symfony\Component\DependencyInjection\Reference;

/**
 * Modifies the language manager service.
 */
class SocialWelcomeMessageServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    //$definition = $container->getDefinition('config_translation.access.overview');
    //$definition->setClass('\Drupal\social_welcome_message\Access\SocialWelcomeMessageTranslationOverviewAccess');

    //$definition = $container->getDefinition('config_translation.access.form');
    //$definition->setClass('\Drupal\social_welcome_message\Access\SocialWelcomeMessageTranslationFormAccess');


  }
}