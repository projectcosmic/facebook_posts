<?php

namespace Drupal\Tests\facebook_posts\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\facebook_posts\Traits\FacebookPostCreationTrait;

/**
 * Tests that the limit configuration setting is respected.
 *
 * @group facebook_posts
 */
class LimitTest extends KernelTestBase {

  use FacebookPostCreationTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'facebook_posts',
  ];

  /**
   * The facebook post entity storage.
   *
   * @var \Drupal\Core\Entity\ContentEntityStorageInterface
   */
  protected $facebookPostStorage;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->installEntitySchema('facebook_post');

    $this->facebookPostStorage = $this->container
      ->get('entity_type.manager')
      ->getStorage('facebook_post');
  }

  /**
   * Tests that the limit configuration setting is respected.
   */
  public function testLimit() {
    $limit = 2;

    $this->config('facebook_posts.settings')
      ->set('limit', $limit)
      ->save(TRUE);

    $this->createFacebookPost();
    $this->createFacebookPost();
    $this->assertCount($limit, $this->facebookPostStorage->loadMultiple());

    $this->createFacebookPost();
    $entity_1 = $this->createFacebookPost();
    $entity_2 = $this->createFacebookPost();

    $stored = $this->facebookPostStorage->loadMultiple();
    $this->assertCount($limit, $stored);
    $this->assertEquals($entity_1->id(), reset($stored)->id());
    $this->assertEquals($entity_2->id(), next($stored)->id());

    $entity_3 = $this->createFacebookPost(['id' => 1]);

    $stored = $this->facebookPostStorage->loadMultiple();
    $this->assertCount($limit, $stored);
    $this->assertArrayHasKey($entity_3->id(), $stored, 'Posts sorted by created date (not ID) before trimming.');
    $this->assertArrayNotHasKey($entity_1->id(), $stored, 'Posts sorted by created date (not ID) before trimming.');
  }

}
