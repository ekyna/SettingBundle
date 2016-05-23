<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection;

/**
 * Class TinymceConfiguration
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TinymceConfiguration
{
    /**
     * Builds the tinymce configuration.
     *
     * @param array $bundles
     * @return array
     */
    public function build(array $bundles)
    {
        $contentCss = [
            'asset[bundles/ekynasetting/css/helper.css]',
            'asset[bundles/ekynacore/css/tinymce-content.css]',
            'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800',
        ];

        $externalPlugins = [];
        if (!in_array('EkynaMediaBundle', $bundles)) {
            $externalPlugins['filemanager'] = '/bundles/ekynamedia/js/tinymce.plugin.js';
        }

        return [
            'theme' => [
                'helper' => [
                    'menubar'       => false,
                    'statusbar'     => true,
                    'resize'        => false,
                    'image_advtab'  => true,
                    'relative_urls' => false,
                    'entity_encoding' => 'raw',
                    'plugins' => [
                        "autoresize advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons paste textcolor template",
                    ],
                    'toolbar1' =>   "undo redo | styleselect  | link image media",
                    'toolbar2' =>   "bold italic forecolor backcolor | alignleft aligncenter " .
                        "alignright alignjustify | bullist numlist outdent indent",
                    'external_plugins' => $externalPlugins,
                    'content_css' => $contentCss,
                ],
            ],
        ];
    }
}
