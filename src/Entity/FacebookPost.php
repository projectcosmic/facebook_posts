<?php

namespace Drupal\facebook_posts\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\facebook_posts\FacebookPostInterface;

/**
 * Defines the facebook post entity class.
 *
 * @ContentEntityType(
 *   id = "facebook_post",
 *   label = @Translation("Facebook Post"),
 *   label_collection = @Translation("Facebook Posts"),
 *   label_singular = @Translation("Facebook post"),
 *   label_plural = @Translation("Facebook posts"),
 *   label_count = @PluralTranslation(
 *     singular = "@count Facebook post",
 *     plural = "@count Facebook posts"
 *   ),
 *   base_table = "facebook_post",
 *   handlers = {
 *     "views_data" = "Drupal\views\EntityViewsData",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "page_id" = "page_id",
 *     "message" = "message",
 *     "created" = "created",
 *   },
 * )
 */
class FacebookPost extends ContentEntityBase implements FacebookPostInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('Unique ID of the post.'))
      ->setReadOnly(TRUE)
      ->setSettings([
        'unsigned' => TRUE,
        'size' => 'big',
      ]);

    $fields['page_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Source page ID'))
      ->setDescription(t('The ID of the page that the post is from.'))
      ->setReadOnly(TRUE)
      ->setSettings([
        'unsigned' => TRUE,
        'size' => 'big',
      ]);

    $fields['message'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Message'))
      ->setDescription(t('The status message in the post.'))
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => 1,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time the post was initially published.'))
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => -5,
      ]);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getPageId() {
    return $this->get('page_id')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getMessage() {
    return $this->get('message')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

}
