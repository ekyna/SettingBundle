<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection;

/**
 * Class AsseticConfiguration
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AsseticConfiguration
{
    /**
     * Builds the assetic configuration.
     *
     * @param array $config
     * @return array
     */
    public function build(array $config)
    {
        $output = [];

        // Fix path in output dir
        if ('/' !== substr($config['output_dir'], -1) && strlen($config['output_dir']) > 0) {
            $config['output_dir'] .= '/';
        }

        $output['helper_css'] = $this->buildCss($config);

        return $output;
    }

    /**
     * Builds helper.css asset collection.
     *
     * @param array $config
     * @return array
     */
    protected function buildCss(array $config)
    {
        $inputs = [
            '%kernel.root_dir%/../web/assets/bootstrap/css/bootstrap.min.css',
            '@EkynaSettingBundle/Resources/asset/helper.css',
        ];

        return [
            'inputs'  => $inputs,
            'filters' => ['yui_css'], // 'cssrewrite'
            'output'  => $config['output_dir'].'css/admin-helper.css',
            'debug'   => false,
        ];
    }
}
