<?php

namespace Drupal\social_welcome_message\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Drupal\group\Entity\Group;
use Drupal\group\Entity\GroupInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;

/**
 * Provides a 'SocialWelcomeMessageLocalActionsBlock' block.
 *
 * @Block(
 *  id = "social_welcome_message_actions_block",
 *  admin_label = @Translation("Social Welcome Message Actions block"),
 * )
 */
class SocialWelcomeMessageLocalActionsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * EventAddBlock constructor.
   *
   * @param array $configuration
   *   The given configuration.
   * @param string $plugin_id
   *   The given plugin id.
   * @param mixed $plugin_definition
   *   The given plugin definition.
   * @param \Drupal\Core\Routing\RouteMatchInterface $routeMatch
   *   The route match.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $routeMatch) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $routeMatch;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    $group_id = \Drupal::routeMatch()->getParameter('group');
    // Load the user for Role check
    $user = User::load($account->id());

    if (isset($group_id) && !empty($group_id)) {

      $group = Group::load($group_id);

      if ($group) {

          $member = $group->getMember($account);

          if ($member) {
            if($member->hasPermission('edit group', $account)) {
              return AccessResult::allowed();
            }
          }
          elseif ($user->hasRole('administrator')) {
            return AccessResult::allowed()->cachePerUser();
          }
          else {            
            return AccessResult::forbidden()->cachePerUser();
          }

      }
      else {
        return AccessResult::forbidden()->cachePerUser();
      }

    }
    else {
      return AccessResult::forbidden()->cachePerUser();
    }


    return AccessResult::neutral();

  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    $cache_contexts = parent::getCacheContexts();    
    return $cache_contexts;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $cache_tags = parent::getCacheTags();
    return $cache_tags;
  }

  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    // Get current group so we can build correct links.
    $group_id = \Drupal::routeMatch()->getParameter('group');
    $group = Group::load($group_id);
    if ($group instanceof GroupInterface) {

      $links = [
        'add_member' => [
          '#type' => 'link',
          '#title' => $this->t('Add members'),
          '#url' => Url::fromRoute('entity.group_content.add_form',['group' => $group->id(),'plugin_id' => 'group_membership']),
          '#attributes' => [
            'class' => ['action-button','btn','btn-default'],
          ]
        ],
        'manage_welcome_message' => [
          '#type' => 'link',
          '#title' => $this->t('Manage Welcome Message'),
          '#url' => Url::fromRoute('entity.social_welcome_message.add_form', ['group' => $group->id()]
              ),
          '#attributes' => [
            'class' => ['social-welcome-message-action-button','btn','btn-default'],
          ],
        ],
        'user_import' => [
          '#type' => 'link',
          '#title' => $this->t('Import Users'),
          '#url' => Url::fromRoute('csvimport',['group' => $group->id()]),
          '#attributes' => [
            'class' => ['action-button','btn','btn-default'],
          ]
        ]
      ];

      $build['content'] = $links;
      $build['content']['#attached'] = [
        'library' => [
          'social_welcome_message/design',
        ],
      ];

    }

    return $build;

  }

}
