<?php

namespace Drupal\social_welcome_message\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Welcome Message Logs edit forms.
 *
 * @ingroup social_welcome_message
 */
class SocialWelcomeMessageLoggerForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    $instance = parent::create($container);
    $instance->account = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var \Drupal\social_welcome_message\Entity\SocialWelcomeMessageLogger $entity */
    $form = parent::buildForm($form, $form_state);

    return $form;
    
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Welcome Message Logs.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Welcome Message Logs.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.social_welcome_message_logger.canonical', ['social_welcome_message_logger' => $entity->id()]);
  }

}
