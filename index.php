<?php

use Kirby\Cms\App as Kirby;
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

Kirby::plugin('deichrakete/cache', [
    'components' => [
        'css' => function (Kirby $kirby, string $url, $options = null): string
        {
            if (option('deichrakete.cache.buster.css')) {
                return getFileModfied($kirby, $url);
            }

            return $url;
        },
        'js' => function (Kirby $kirby, string $url, $options = null): string
        {
            if (option('deichrakete.cache.buster.js')) {
                return getFileModfied($kirby, $url);
            }

            return $url;
        },
    ],
    'options' => [
        'buster' => [
            'css' => true,
            'js' => true,
        ]
    ],
]);
