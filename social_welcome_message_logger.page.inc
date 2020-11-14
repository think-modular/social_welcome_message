<?php

/**
 * @file
 * Contains social_welcome_message_logger.page.inc.
 *
 * Page callback for Welcome Message Logs entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Welcome Message Logs templates.
 *
 * Default template: social_welcome_message_logger.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_social_welcome_message_logger(array &$variables) {
  // Fetch SocialWelcomeMessageLogger Entity Object.
  $social_welcome_message_logger = $variables['elements']['#social_welcome_message_logger'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
