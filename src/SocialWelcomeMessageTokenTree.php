<?php

namespace Drupal\social_welcome_message;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

class SocialWelcomeMessageTokenTree extends ServiceProviderBase {

  public function alter ( ContainerBuilder $container ) {

    $definition = $container->getDefinition ( 'token.tree_builder' );
    $definition->setClass ( 'Drupal\social_welcome_message\SocialWelcomeMessageTokenTreeBuilder' );
  
  }
}