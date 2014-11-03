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
     * @param array $config
     * @return array
     */
    public function build(array $config)
    {
        $contentCss = array(
            '/css/admin-helper.css',
            '/bundles/ekynacore/css/tinymce-content.css',
            'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800',
        );

        if (0 < strlen($config['ui']['google_font_url'])) {
            $contentCss[] = $config['ui']['google_font_url'];
        }

        return array(
            'theme' => array(
                'helper' => array(
                    'menubar'       => false,
                    'statusbar'     => true,
                    'resize'        => false,
                    'image_advtab'  => true,
                    'relative_urls' => false,
                    'plugins' => array(
                        "autoresize advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons paste textcolor template",
                    ),
                    'toolbar1' =>   "undo redo | styleselect  | link image media",
                    'toolbar2' =>   "bold italic forecolor backcolor | alignleft aligncenter " .
                        "alignright alignjustify | bullist numlist outdent indent",
                    'external_plugins' => array(
                        'filemanager' => "/bundles/ekynafilemanager/js/tinymce.plugin.js",
                    ),
                    'content_css' => $contentCss,
                ),
            ),
        );
    }
}
