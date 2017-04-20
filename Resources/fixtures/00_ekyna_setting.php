<?php

declare(strict_types=1);

use Ekyna\Bundle\SettingBundle as Setting;

return [
    Setting\Model\RedirectionInterface::class => [
        'redirect_1' => [
            '__factory' => [
                '@ekyna_setting.factory.redirection::create' => [],
            ],
            'fromPath'  => '/foo',
            'toPath'    => '/bar', // TODO Should be a valid path (200)
        ],
    ],
    Setting\Entity\Helper::class      => [
        'helper_1' => [
            '__factory' => [
                '@ekyna_setting.factory.helper::create' => [],
            ],
            'name'      => 'Test helper',
            'reference' => 'TEST',
            'content'   => '<identity("<p>Some test helper content.</p>")>',
            'enabled'   => true,
        ],
    ],
];
