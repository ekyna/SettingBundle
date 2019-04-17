<?php

namespace Ekyna\Bundle\SettingBundle\Form\Type;

use Ekyna\Bundle\SettingBundle\Model\I18nParameter;
use Ekyna\Component\Resource\Locale\LocaleProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class I18nParameterType
 * @package Ekyna\Bundle\SettingBundle\Form\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class I18nParameterType extends AbstractType
{
    /**
     * @var LocaleProviderInterface
     */
    private $localeProvider;


    /**
     * Constructor.
     *
     * @param LocaleProviderInterface $localeProvider
     */
    public function __construct(LocaleProviderInterface $localeProvider)
    {
        $this->localeProvider = $localeProvider;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['locales'] as $locale) {
            $builder->add($locale, $options['form_type'],
                $options['form_options'] + [
                    'required' => in_array($locale, $options['required_locales'], true),
                ]
            );
        }

        $builder
            ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
                $data = $event->getData();

                foreach ($data as $locale => $translation) {
                    if (empty($translation)) {
                        unset($data[$locale]);
                    }
                }

                $event->setData($data);
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
                /** @var I18nParameter $data */
                $data = $event->getData();

                $data->setCurrentLocale($this->localeProvider->getCurrentLocale());
                $data->setFallbackLocale($this->localeProvider->getFallbackLocale());
            });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['default_locale'] = $options['default_locale'];
        $view->vars['required_locales'] = $options['required_locales'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('form_type')
            ->setDefaults([
                'form_options'     => [],
                'data_class'       => I18nParameter::class,
                'by_reference'     => false,
                'empty_data'       => function () {
                    return new I18nParameter();
                },
                'locales'          => $this->localeProvider->getAvailableLocales(),
                'default_locale'   => $this->localeProvider->getFallbackLocale(),
                'required_locales' => [$this->localeProvider->getFallbackLocale()],
            ]);
    }

    public function getBlockPrefix(): string
    {
        return 'a2lix_translations';
    }
}
