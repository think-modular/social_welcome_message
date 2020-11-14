<?php

/**
 * Implements hook_views_data_alter().
 */
function social_welcome_message_views_data_alter(array &$data) {


  $data['users_field_data']['social_welcome_message_logger'] = [
  'relationship' => [
    //Display name in View Relationship section
    'title' => 'Social Welcome Message relationship',
    'help' => 'Join User and Social Welcome Message Logger entities by user',
    //the name of the table
    'base' => 'social_welcome_message_logger',
    //Field in users_field_data table
    'base field' => 'user_id',
    //`name` field in Player table
    'relationship field' => 'uid',
    'field' => 'uid',
    'id' => 'social_welcome_message'
  ]
];

}


