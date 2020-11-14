<?php

namespace Drupal\social_welcome_message\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber.
 *
 * @package Drupal\social_welcome_message\Routing
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Add controller for specific route
    if ($route = $collection->get('entity.social_welcome_message.add_form')) {
      $route->setDefault('_controller', '\Drupal\social_welcome_message\Controller\SocialWelcomeMessageController::redirectToEditForm');
      //$route->setRequirement('_access', TRUE);
    }
    if ($route = $collection->get('entity.social_welcome_message.canonical')) {
      $route->setDefault('_controller', '\Drupal\social_welcome_message\Controller\SocialWelcomeMessageController::viewSocialWelcomeMessage');
    }
    if ($route = $collection->
      get('entity.social_welcome_message.canonical')) {
      //$route->setRequirement('_permission', 'translate welcome messages');
    }

  }

}
