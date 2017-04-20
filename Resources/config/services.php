<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Ekyna\Bundle\SettingBundle\Action;
use Ekyna\Bundle\SettingBundle\Controller\HelperController;
use Ekyna\Bundle\SettingBundle\EventListener\RedirectionEventSubscriber;
use Ekyna\Bundle\SettingBundle\Form;
use Ekyna\Bundle\SettingBundle\Manager\SettingManager;
use Ekyna\Bundle\SettingBundle\Manager\SettingManagerInterface;
use Ekyna\Bundle\SettingBundle\Schema\SchemaRegistry;
use Ekyna\Bundle\SettingBundle\Service\Redirection\RedirectionBuilder;
use Ekyna\Bundle\SettingBundle\Service\Redirection\RedirectionProvider;
use Ekyna\Bundle\SettingBundle\Show;
use Ekyna\Bundle\SettingBundle\Twig\SettingExtension;
use Ekyna\Bundle\SettingBundle\Validator\Constraints\RedirectionValidator;

return static function (ContainerConfigurator $container) {
    $container
        ->services()

        // Cache
        ->set('ekyna_setting.cache')
            ->parent('cache.app')
            ->private()
            ->tag('cache.pool', ['clearer' => 'cache.default_clearer'])

        // Schema registry
        ->set('ekyna_setting.registry', SchemaRegistry::class)

        // Setting manager
        ->set('ekyna_setting.manager', SettingManager::class)->public()
            ->args([
                service('ekyna_setting.registry'),
                service('ekyna_setting.manager.parameter'),
                service('ekyna_setting.repository.parameter'),
                service('ekyna_resource.provider.locale'),
                service('validator'),
                service('ekyna_setting.cache'),
            ])
            ->tag('twig.runtime')
            ->alias(SettingManagerInterface::class, 'ekyna_setting.manager')->public()

        // Actions
        ->set(Action\ParametersReadAction::class)
            ->args([
                service('ekyna_setting.manager'),
                service('ekyna_setting.registry'),
            ])
            ->tag('ekyna_resource.action')
        ->set(Action\ParametersUpdateAction::class)
            ->args([
                service('ekyna_setting.manager'),
                service('ekyna_setting.registry'),
            ])
            ->tag('ekyna_resource.action')

        // Controller
        ->set('ekyna_setting.controller.helper', HelperController::class)
            ->args([
                service('ekyna_setting.repository.helper'),
                service('twig'),
                abstract_arg('The configured remotes'),
            ])
            ->alias(HelperController::class, 'ekyna_setting.controller.helper')->public()

        // Form types
        ->set('ekyna_setting.form_type.i18n_parameter', Form\Type\I18nParameterType::class)
            ->args([
                service('ekyna_resource.provider.locale'),
            ])
            ->tag('form.type')

        // Show types
        ->set('ekyna_setting.show_type.i18n_parameter', Show\Type\I18nParameterType::class)
            ->args([
                param('ekyna_resource.locales'),
            ])
            ->tag('ekyna_admin.show.type')

        // Redirection provider
        ->set('ekyna_setting.redirection_provider', RedirectionProvider::class)
            ->args([
                service('ekyna_setting.repository.redirection'),
                service('ekyna_setting.manager.redirection'),
            ])
            ->tag('ekyna_resource.redirection_provider')

        // Redirection builder
        ->set('ekyna_setting.redirection_builder', RedirectionBuilder::class)
            ->args([
                service('ekyna_setting.factory.redirection'),
                service('ekyna_setting.repository.redirection'),
                service('ekyna_setting.manager.redirection'),
            ])

        // Redirection event subscriber
        ->set('ekyna_setting.listener.redirection', RedirectionEventSubscriber::class)
            ->args([
                service('ekyna_setting.redirection_builder')
            ])
            ->tag('kernel.event_subscriber')

        // Redirection constraint validator
        ->set('ekyna_setting.validator.redirection', RedirectionValidator::class)
            ->args([
                service('request_stack'),
                service('security.http_utils'),
            ])
            ->tag('validator.constraint_validator')

        // Twig extension
        ->set('ekyna_setting.twig.extension.setting', SettingExtension::class)
            ->tag('twig.extension')
    ;
};
