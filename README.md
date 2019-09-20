# Facebook Posts

Pull posts from a Facebook Page.

Posts are created in Drupal as `facebook_post` entities. Only the number of
entities described by `facebook_posts.settings.limit` will ever exist on the
server at any one time.

Posts can also be displayed via Views.

## Installation

Download into a Drupal project via composer:

```
composer require projectcosmic/facebook_posts
```

## Configuration

1. Enable the module.
2. Edit the configuration `facebook_posts.settings` for the Facebook app to be
   used.  
   It is recommended to set the more sensitive settings (`app_secret`) in
   the site's `settings.php` so that it is not in any potentially public areas,
   such as VCS.
