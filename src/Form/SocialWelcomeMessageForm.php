<?php

namespace Drupal\social_welcome_message\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\group\GroupStorageInterface;
use Drupal\Core\Routing;
use Drupal\Core\Url;
use Drupal\Core\Utility\Token;

/**
 * Class SocialWelcomeMessageForm.
 */
class SocialWelcomeMessageForm extends EntityForm {



  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $social_welcome_message = $this->entity;

    // Make the label group id to avoid dupication
    // Set the entity reference field and attach given group_id

    // Get the group id
    $group_id = \Drupal::routeMatch()->getParameter('group');


    if ($this->operation == 'add') {

      $social_welcome_message->setGroup($group_id);
      $group_storage = \Drupal::entityTypeManager()->getStorage('group');
      $group = $group_storage->load($social_welcome_message->getGroup());

      $label_default_value = $this->t('Welcome Message for') . ' ' .
                             $group->id() . '-' . $group->label();
      $social_welcome_message->set('label', $label_default_value);

    }

    // Change page title for the edit operation
    if ($this->operation == 'edit') {
      // Get the group id
      $group_storage = \Drupal::entityTypeManager()->getStorage('group');
      $group = $group_storage->load($social_welcome_message->getGroup());

    }


    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $social_welcome_message->label(),
      '#required' => TRUE,
      '#attributes' => ['class' => ['hidden']],
      '#disabled' => TRUE,
      '#title_display' => 'invisible'
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $social_welcome_message->id(),
      '#machine_name' => [
        'exists' => '\Drupal\social_welcome_message\Entity\SocialWelcomeMessage::load',
      ],
      // Hide the machine name
      '#disabled' => !$social_welcome_message->isNew(),
    ];


    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Subject'),
      '#maxlength' => 255,
      '#default_value' => $social_welcome_message->getSubject(),
      '#description' => $this->t("Subject for the Welcome Message."),
      '#required' => TRUE,
    ];

    $form['body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Invitation text new member'),
      '#default_value' => $social_welcome_message->getBody()['value'],
      '#description' => $this->t("Body for the Welcome Message."),
      '#required' => TRUE,
      '#format' => $social_welcome_message->getBody()['format'],
    ];

    $form['body_existing'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Invitation text existing member'),
      '#default_value' => $social_welcome_message->getBodyExisting()['value'],
      '#description' => $this->t("Body for the Welcome Message."),
      '#required' => TRUE,
      '#format' => $social_welcome_message->getBodyExisting()['format'],
    ];

    $form['group'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'group',
      '#default_value' => $group,
      '#title' => $this->t('Group'),
      '#disabled' => TRUE
    ];

    $form['available_tokens'] = array(
      '#type' => 'details',
      '#title' => t('Available Tokens'),
      '#open' => FALSE, // Controls the HTML5 'open' attribute. Defaults to FALSE.
    );

    $suppported_tokens = array('site','user','group');

    $options = [
      'show_restricted' => TRUE,
      'show_nested' => TRUE,
      'global_types' => FALSE,
      'whitelist' =>
        [
          '[user:mail]',
          '[user:one-time-login-url]',
          '[user:display-name]',
          '[group:title]',
          '[site:name]'
        ]
    ];


    $form['available_tokens']['tokens'] = \Drupal::service('social_welcome_message.tree_builder')
      ->buildRenderable($suppported_tokens,$options);



    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $social_welcome_message = $this->entity;

    $status = $social_welcome_message->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Welcome Message.', [
          '%label' => $social_welcome_message->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Welcome Message.', [
          '%label' => $social_welcome_message->label(),
        ]));
    }


    if ($status != SAVED_NEW) {

      $url = Url::fromRoute('view.group_manage_members.page_group_manage_members',['group' => $social_welcome_message->getGroup()]);
      $form_state->setRedirectUrl($url);

    }




  }

}
