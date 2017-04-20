<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Twig;

use Ekyna\Bundle\SettingBundle\Manager\SettingManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SettingsExtension
 * @package Ekyna\Bundle\SettingBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingExtension extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'get_settings',
                [SettingManager::class, 'loadSettings']
            ),
            new TwigFunction(
                'get_setting',
                [SettingManager::class, 'getParameter']
            ),
        ];
    }
}
