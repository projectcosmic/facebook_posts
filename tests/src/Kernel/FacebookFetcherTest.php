<?php

namespace Drupal\Tests\facebook_posts\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * @coversDefaultClass \Drupal\facebook_posts\FacebookFetcher
 * @group facebook_posts
 */
class FacebookFetcherTest extends KernelTestBase {

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

    $response_mock = $this->createMock('\Facebook\FacebookResponse');
    $response_mock->method('getDecodedBody')->willReturn($this->getTestData());

    $sdk_mock = $this->createMock('\Facebook\Facebook');
    $sdk_mock->method('get')->willReturn($response_mock);
    $this->container->set('facebook_posts.sdk', $sdk_mock);
  }

  /**
   * @covers ::fetch
   */
  public function testFetch() {
    $this->config('facebook_posts.settings')->set('limit', 1)->save(TRUE);
    $this->container->get('facebook_posts.fetcher')->fetch();

    $posts = $this->facebookPostStorage->loadMultiple();
    $this->assertCount(1, $posts, 'Posts gets saved.');

    $post = reset($posts);
    $fixture = $this->getTestData()['data'][0];

    $this->assertEquals(316835782222141, $post->id());
    $this->assertEquals(165835107322210, $post->getPageId());
    $this->assertEquals($fixture['message'], $post->getMessage());
    $this->assertEquals(1534409033, $post->getCreatedTime());

    $this->config('facebook_posts.settings')->set('limit', 2)->save(TRUE);
    $this->container->get('facebook_posts.fetcher')->fetch();
    $this->assertCount(
      2,
      $this->facebookPostStorage->loadMultiple(),
      'More posts gets saved if we have not hit the limit.'
    );
  }

  /**
   * Fixture data for raw Facebook post data.
   *
   * @return array
   *   A fixture of decoded body of a page's posts feed.
   */
  protected function getTestData() {
    return [
      'data' => [
        [
          'created_time' => '2018-08-16T08:43:53+0000',
          'message' => "PLEASE NOTE that on Friday 17 August, the Viridor Credits office will be closed for staff training.\nWe won't be able to take any calls or respond to any emails at this time but we'll get back to you as soon as possible on our return on Monday.",
          'id' => '165835107322210_316835782222141',
        ],
        [
          'created_time' => '2018-07-09T12:10:05+0000',
          'message' => "A round of applause for Wharton and Cleggs Lane Church and Community Centre who have been awarded funding by Viridor Credits Environmental Company via #theLCF to build a new community centre and church!\n\n@ENTRUSTReg #theLCF Viridor\n\nTo check if you're eligible for funding, visit http://www.viridor-credits.co.uk",
          'id' => '165835107322210_281951869043866',
        ],
      ],
    ];
  }

}
