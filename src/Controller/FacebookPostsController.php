<?php

namespace Drupal\facebook_posts\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\Url;
use Facebook\Facebook;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller routines for facebook_posts routes.
 */
class FacebookPostsController {

  use StringTranslationTrait;

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
   * The Facebook fetcher service.
   *
   * @var \Drupal\facebook_posts\FacebookFetcherInterface
   */
  protected $facebookFetcher;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The state service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a FacebookPostsController.
   *
   * @param \Facebook\Facebook $instance
   *   An instance of the Facebook PHP SDK.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The translation service.
   */
  public function __construct(Facebook $instance, ConfigFactoryInterface $config_factory, StateInterface $state, MessengerInterface $messenger, TranslationInterface $string_translation) {
    $this->sdkInstance = $instance;
    $this->config = $config_factory->get('facebook_posts.settings');
    $this->state = $state;
    $this->messenger = $messenger;
    $this->stringTranslation = $string_translation;
  }

  /**
   * Returns a page for getting an user access token to get page posts.
   *
   * @return array
   *   The page.
   */
  public function authenticate() {
    $redirect = Url::fromRoute('facebook_posts.receive_token', [], ['absolute' => TRUE])->toString();
    $auth_url = $this->sdkInstance
      ->getRedirectLoginHelper()
      ->getLoginUrl($redirect, ['manage_pages']);

    return [
      'content' => [
        '#markup' => '<p>' . $this->t('For the site to pull in posts from the configured Facebook page, it requires an authentication token from a user that has administrative access to the page. Please use the button below to start.') . '</p>',
      ],
      'link' => [
        '#type' => 'link',
        '#title' => $this->t('Login with Facebook'),
        '#url' => Url::fromUri($auth_url),
        '#attributes' => [
          'class' => [
            'button',
            'button--primary',
          ],
        ],
      ],
    ];
  }

  /**
   * Endpoint to receive a token from Facebook OAuth.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect response to the homepage.
   */
  public function receiveToken() {
    try {
      $token = $this->sdkInstance
        ->getRedirectLoginHelper()
        ->getAccessToken();

      if ($token) {
        $found = FALSE;
        $response = $this->sdkInstance
          ->get('me/accounts', $token)
          ->getDecodedBody();

        // Set access token for matching page.
        foreach ($response['data'] as $page) {
          if ($this->config->get('page_id') == $page['id']) {
            $this->state->set('facebook_posts.access_token', $page['access_token']);
            $found = TRUE;
            break;
          }
        }

        if ($found) {
          $this->messenger->addStatus($this->t('Successfully authenticated.'));
        }
        else {
          throw new Exception($this->t(
            'There was insufficient permissions to access the Facebook page.'
          ));
        }
      }
    }
    catch (\Exception $error) {
      $this->messenger->addError($this->t(
        'We were unable to authenticate with Facebook: @error <a href=":url">Try again.</a>',
        [
          '@error' => $error->getMessage(),
          ':url' => Url::fromRoute('facebook_posts.authorization')->toString(),
        ]
      ));
    }

    return new RedirectResponse(Url::fromRoute('<front>')->toString());
  }

}
