<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Show\Type;

use Ekyna\Bundle\AdminBundle\Show\Exception\UnexpectedTypeException;
use Ekyna\Bundle\AdminBundle\Show\Type\AbstractType;
use Ekyna\Bundle\AdminBundle\Show\View;
use Ekyna\Bundle\SettingBundle\Model\I18nParameter;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function base64_encode;
use function preg_replace;
use function random_bytes;

/**
 * Class I18nParameterType
 * @package Ekyna\Bundle\SettingBundle\Show\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class I18nParameterType extends AbstractType
{
    private array $locales;


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
    public function build(View $view, $value, array $options = []): void
    {
        if (!$value instanceof I18nParameter) {
            throw new UnexpectedTypeException($value, I18nParameter::class);
        }

        $value = $value->getIterator();

        parent::build($view, $value, $options);

        $prefix = $options['prefix'] ?? $options['id'] ?? 'translations';

        $name = $prefix . '_' . preg_replace('~[^A-Za-z0-9]+~', '', base64_encode(random_bytes(3)));

        $view->vars = array_replace($view->vars, [
            'locales' => $this->locales,
            'prefix'  => $prefix,
            'name'    => $name,
            'type'    => $options['type'],
            'options' => $options['options'],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function configureOptions(OptionsResolver $resolver): void
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
    public static function getName(): string
    {
        return 'setting_i18n_parameter';
    }
}
