<?php
/**
 * Cache Plugin
 *
 * @version   1.0.0-beta.1
 * @link      https://github.com/foerdeliebe/kirby-cache
 * @license   MIT
 */

use Kirby\Cms\App as Kirby;
use Kirby\Cms\Page;
use Kirby\Http\Response;
use Kirby\Cms\Url;
use Kirby\Filesystem\F;

/**
 * Get the file with modified timestamp
 *
 * @param Kirby $kirby
 * @param string $file
 * @return string
 */
function getFileModfied(Kirby $kirby, string $file): string
{
    $relative_url = Url::path($file, false);
    $file_root = $kirby->root('index') . '/' . $relative_url;

    if (F::exists($file_root)) {
        return url($relative_url . '?' . F::modified($file_root));
    }

    return $file;
}

Kirby::plugin('foerdeliebe/cache', [
    'components' => [
        'css' => function (Kirby $kirby, string $url, $options = null): string
        {
            if (option('foerdeliebe.cache.buster.css')) {
                return getFileModfied($kirby, $url);
            }

            return $url;
        },
        'js' => function (Kirby $kirby, string $url, $options = null): string
        {
            if (option('foerdeliebe.cache.buster.js')) {
                return getFileModfied($kirby, $url);
            }

            return $url;
        },
    ],
    'hooks' => [
        'route:after' => function ($result): Page|Response|null
        {
            if (option('foerdeliebe.cache.last-modified') && $result instanceof Page) {
                header('Last-Modified: ' . $result->modified('F d Y H:i:s.'));
            }
            return $result;
        },
    ],
    'options' => [
        'buster' => [
            'css' => true,
            'js' => true,
        ],
        'last-modified' => true,
    ],
]);
