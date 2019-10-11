<?php

namespace Drupal\facebook_posts;

/**
 * Interface describing a Facebook posts fetcher.
 */
interface FacebookFetcherInterface {

  /**
   * Fetches any new posts from the Facebook page.
   *
   * @param \Facebook\Authentication\AccessToken\AccessToken|string $token
   *   The token to authenticate a {page_id}/feed GET request with.
   */
  public function fetch($token);

}
