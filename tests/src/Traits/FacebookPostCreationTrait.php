<?php

namespace Drupal\Tests\facebook_posts\Traits;

use Drupal\facebook_posts\Entity\FacebookPost;

/**
 * Provides methods to create test facebook_post entities.
 *
 * This trait is meant to be used only by test classes.
 */
trait FacebookPostCreationTrait {

  /**
   * The next post index to use.
   *
   * @var int
   */
  protected $facebookPostsIndex = 100;

  /**
   * Create and saves a test Facebook post entity.
   *
   * @param array $params
   *   Any parameters to create the post with
   * @return \Drupal\facebook_posts\Entity\FacebookPost
   *   The entity.
   */
  protected function createFacebookPost($params = []) {
    $post = FacebookPost::create($params + [
      'id' => $this->facebookPostsIndex,
      'page_id' => 123456789012345,
      'message' => $this->randomString(),
      'created' => 1500000 + $this->facebookPostsIndex,
    ]);
    $post->save();

    $this->facebookPostsIndex += rand(1, 20);

    return $post;
  }

}
