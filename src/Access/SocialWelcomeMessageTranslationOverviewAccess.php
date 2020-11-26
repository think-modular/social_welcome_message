<?php

namespace Drupal\social_welcome_message\Access;


use Drupal\config_translation\Access\ConfigTranslationOverviewAccess;
use Drupal\config_translation\ConfigMapperInterface;
use Drupal\config_translation\Exception\ConfigMapperLanguageException;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\config_translation\ConfigMapperManagerInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\group\Entity\Group;
use Drupal\group\Entity\GroupInterface;
use Drupal\Core\Config\ConfigManager;
use Drupal\Core\Config\ConfigManagerInterface;



class SocialWelcomeMessageTranslationOverviewAccess extends ConfigTranslationOverviewAccess implements AccessInterface {

  /**
   * Checks access to the overview based on permissions and translatability.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route_match to check against.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account to check access for.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(RouteMatchInterface $route_match, AccountInterface $account) {

    $mapper = $this
      ->getMapperFromRouteMatch($route_match);
    try {
      $langcode = $mapper
        ->getLangcode();
    } catch (ConfigMapperLanguageException $exception) {

      // ConfigTranslationController shows a helpful message if the language
      // codes do not match, so do not let that prevent granting access.
      $langcode = 'en';
    }

    $source_language = $this->languageManager
      ->getLanguage($langcode);   

    if ($route_match->getParameters()->get('plugin_id') === 'social_welcome_message') {
      return $this
        ->doCheckAccessEntity($account, $mapper, $source_language);
    }
    
    return $this
      ->doCheckAccess($account, $mapper, $source_language);

  }

  /**
   * Checks access given an account, configuration mapper, and source language.
   *
   * Grants access if the proper permission is granted to the account, the
   * configuration has translatable pieces, and the source language is not
   * locked given it is present.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account to check access for.
   * @param \Drupal\config_translation\ConfigMapperInterface $mapper
   *   The configuration mapper to check access for.
   * @param \Drupal\Core\Language\LanguageInterface|null $source_language
   *   The source language to check for, if any.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The result of the access check.
   */
  protected function doCheckAccess(AccountInterface $account, ConfigMapperInterface $mapper, $source_language = NULL) {

		$base_access_result = parent::doCheckAccess($account, $mapper, $source_language);

		 $access = $account
      ->hasPermission('translate configuration') && $mapper
      ->hasSchema() && $mapper
      ->hasTranslatable() && (!$source_language || !$source_language
      ->isLocked());


     return $base_access_result
      ->andIf(AccessResult::allowedIf($access));

  }

  protected function doCheckAccessEntity(AccountInterface $account, ConfigMapperInterface $mapper, $source_language = NULL) {

  	$access = $account
      ->hasPermission('translate welcome messages') && $mapper
      ->hasSchema() && $mapper
      ->hasTranslatable() && (!$source_language || !$source_language
      ->isLocked());

		return AccessResult::allowedIf($access)
      ->cachePerPermissions();

  }

}