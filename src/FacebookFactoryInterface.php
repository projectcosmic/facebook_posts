<?php

namespace Drupal\facebook_posts;

/**
 * The interface for a Facebook fetcher object.
 */
interface FacebookFactoryInterface {

  /**
   * Creates a Facebook fetcher.
   *
   * @return \Facebook\Facebook
   *   The fetcher object.
   */
  public function create();

}
