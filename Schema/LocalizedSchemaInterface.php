<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Ekyna\Bundle\SettingBundle\Model\I18nParameter;
use Ekyna\Component\Resource\Locale\LocaleProviderAwareInterface;

/**
 * Interface LocalizedSchemaInterface
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface LocalizedSchemaInterface extends LocaleProviderAwareInterface
{
    /**
     * Creates a localized parameter.
     *
     * @param string $value
     *
     * @return I18nParameter
     */
    public function createI18nParameter(string $value): I18nParameter;
}
