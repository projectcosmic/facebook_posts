<?php

namespace Drupal\facebook_posts;

/**
 * Interface describing a Facebook posts fetcher.
 */
interface FacebookFetcherInterface {

  /**
   * Fetches any new posts from the Facebook page.
   */
  public function fetch();

}
