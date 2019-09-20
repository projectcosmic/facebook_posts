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
    $access_token = 'let_me_in';

    $config = $this->createMock('Drupal\Core\Config\ImmutableConfig');
    $config->method('get')->will($this->returnValueMap([
      ['app_id', $app_id],
      ['app_secret', $app_secret],
      ['access_token', $access_token],
    ]));

    $config_factory = $this->createMock('Drupal\Core\Config\ConfigFactoryInterface');
    $config_factory->method('get')
      ->with('facebook_posts.settings')
      ->willReturn($config);

    $instance = (new FacebookFactory($config_factory))->create();
    $app = $instance->getApp();

    $this->assertEquals($app_id, $app->getId());
    $this->assertEquals($app_secret, $app->getSecret());
    $this->assertEquals($access_token, $instance->getDefaultAccessToken());
  }

}
