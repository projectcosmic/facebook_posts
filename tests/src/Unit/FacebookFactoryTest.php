<?php

namespace Drupal\Tests\facebook_posts\Kernel;

use Drupal\facebook_posts\FacebookFactory;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\facebook_posts\FacebookFactory
 * @group facebook_posts
 */
class FacebookFactoryTest extends UnitTestCase {

  /**
   * @covers ::create
   */
  public function testCreate() {
    $app_id = 'foobar';
    $app_secret = 'this_is_a_secret';

    $config_factory = $this->getConfigFactoryStub([
      'facebook_posts.settings' => [
        'app_id' => $app_id,
        'app_secret' => $app_secret,
      ],
    ]);

    $instance = (new FacebookFactory($config_factory))->create();
    $app = $instance->getApp();

    $this->assertEquals($app_id, $app->getId());
    $this->assertEquals($app_secret, $app->getSecret());
  }

}
