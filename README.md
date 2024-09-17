# Simple Kirby cache plugin

This is a simple cache plugin for Kirby, a file-based CMS. At the moment it allows you to add a cache-buster for the `css()` and `js()` functions.

## Installation

1. Download the plugin files.
1. Copy the `cache` folder into the `site/plugins` directory of your Kirby installation or
    - `composer require deichrakete/kirby-cache` or
    - `git submodule add https://github.com/deichrakete/kirby-cache.git site/plugins/cache`
1. The plugin is enabled by default

## Config options

```php
# everything is true by default
'deichrakete.cache.options' => [
  'buster' => [
    'css' => false,
    'js' => false,
  ]
]
```
