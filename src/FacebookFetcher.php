<?php

namespace Drupal\facebook_posts;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Facebook\Facebook;

/**
 * The facebook posts fetcher service.
 */
class FacebookFetcher implements FacebookFetcherInterface {

  /**
   * An instance of the Facebook SDK.
   *
   * @var \Facebook\Facebook
   */
  protected $sdkInstance;

  /**
   * The 'facebook_posts.settings' config.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;


  /**
   * The facebook_post entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $facebookPostStorage;

  /**
   * Constructs a FacebookFetcher.
   *
   * @param \Facebook\Facebook $instance
   *   An instance of the Facebook PHP SDK.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(Facebook $instance, ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager) {
    $this->sdkInstance = $instance;
    $this->config = $config_factory->get('facebook_posts.settings');
    $this->facebookPostStorage = $entity_type_manager->getStorage('facebook_post');
  }

  /**
   * {@inheritdoc}
   */
  public function fetch($token) {
    $page = $this->config->get('page_id');
    $limit = $this->config->get('limit');

    $response = $this->sdkInstance
      ->get("/$page/feed?limit=$limit", $token)
      ->getDecodedBody();

    foreach ($response['data'] as $post) {
      list($page_id, $post_id) = explode('_', $post['id']);

      if ($this->facebookPostStorage->load($post_id)) {
        continue;
      }

      $this->facebookPostStorage->create([
        'id' => $post_id,
        'page_id' => $page_id,
        'message' => $post['message'],
        'created' => strtotime($post['created_time']),
      ])->save();
    }
  }

}
