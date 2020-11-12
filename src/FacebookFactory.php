<?php

namespace Drupal\facebook_posts;

use Drupal\Core\Config\ConfigFactoryInterface;
use Facebook\Facebook;

/**
 * The Facebook fetcher object service.
 */
class FacebookFactory implements FacebookFactoryInterface {

  /**
   * The 'facebook_posts.settings' config.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Constructs a FacebookFactory.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('facebook_posts.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function create() {
    return new Facebook([
      'app_id' => $this->config->get('app_id'),
      'app_secret' => $this->config->get('app_secret'),
      'default_graph_version' => 'v9.0',
    ]);
  }

}
