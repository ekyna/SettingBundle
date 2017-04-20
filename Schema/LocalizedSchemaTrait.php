<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Schema;

use Ekyna\Bundle\SettingBundle\Model\I18nParameter;
use Ekyna\Component\Resource\Locale\LocaleProviderAwareTrait;

/**
 * Trait LocalizedSchemaTrait
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
trait LocalizedSchemaTrait
{
    use LocaleProviderAwareTrait;


    /**
     * Creates a localized parameter.
     *
     * @param string $value
     *
     * @return I18nParameter
     */
    public function createI18nParameter(string $value): I18nParameter
    {
        $current = $this->localeProvider->getCurrentLocale();
        $fallback = $this->localeProvider->getFallbackLocale();

        $trans = new I18nParameter([
            $fallback => $value,
        ]);

        $trans->setCurrentLocale($current);
        $trans->setFallbackLocale($fallback);

        return $trans;
    }
}
