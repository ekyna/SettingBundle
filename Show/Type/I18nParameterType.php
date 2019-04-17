<?php

namespace Ekyna\Bundle\SettingBundle\Show\Type;

use Ekyna\Bundle\AdminBundle\Show\Type\AbstractType;
use Ekyna\Bundle\AdminBundle\Show\View;
use Ekyna\Bundle\SettingBundle\Model\I18nParameter;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class I18nParameterType
 * @package Ekyna\Bundle\SettingBundle\Show\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class I18nParameterType extends AbstractType
{
    /**
     * @var array
     */
    private $locales;


    /**
     * Constructor.
     *
     * @param array $locales
     */
    public function __construct(array $locales)
    {
        $this->locales = $locales;
    }

    /**
     * @inheritDoc
     */
    public function build(View $view, $value, array $options = [])
    {
        if (!$value instanceof I18nParameter) {
            throw new \UnexpectedValueException("Expected instance of " . I18nParameter::class);
        }

        $value = $value->getIterator();

        parent::build($view, $value, $options);

        $prefix = $options['prefix'] ?? $options['id'] ?? 'translations';

        $view->vars = array_replace($view->vars, [
            'locales' => $this->locales,
            'prefix'  => $prefix,
            'name'    => $prefix . '_' . preg_replace('~[^A-Za-z0-9]+~', '', base64_encode(random_bytes(3))),
            'type'    => $options['type'],
            'options' => $options['options'],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label_col'  => 0,
                'widget_col' => 12,
                'type'       => 'text',
                'options'    => [],
                'prefix'     => null,
            ])
            ->setAllowedTypes('type', 'string')
            ->setAllowedTypes('options', 'array')
            ->setAllowedTypes('prefix', ['null', 'string']);
    }

    /**
     * @inheritDoc
     */
    public function getWidgetPrefix()
    {
        return 'i18n_parameter';
    }
}
