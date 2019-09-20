<?php

namespace Drupal\facebook_posts;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\TypedData\TranslationStatusInterface;

/**
 * Provides an interface defining a facebook_post entity.
 */
interface FacebookPostInterface extends ContentEntityInterface, TranslationStatusInterface {

  /**
   * Gets the ID of the page of the source of the post.
   *
   * @return int
   *   The page ID.
   */
  public function getPageId();

  /**
   * Gets the status message of the post.
   *
   * @return string
   *   The status message.
   */
  public function getMessage();

  /**
   * Gets the timestamp of when the post was published on Facebook.
   *
   * @return int
   *   Creation timestamp of the post.
   */
  public function getCreatedTime();

}
