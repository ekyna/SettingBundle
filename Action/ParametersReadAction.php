<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Action;

use Ekyna\Bundle\AdminBundle\Action\AdminActionInterface;
use Ekyna\Bundle\AdminBundle\Action\Util\BreadcrumbTrait;
use Ekyna\Bundle\ResourceBundle\Action\AbstractAction;
use Ekyna\Bundle\ResourceBundle\Action\TemplatingTrait;
use Ekyna\Bundle\SettingBundle\Manager\SettingManagerInterface;
use Ekyna\Bundle\SettingBundle\Schema\SchemaRegistryInterface;
use Ekyna\Component\Resource\Action\Permission;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ParametersReadAction
 * @package Ekyna\Bundle\SettingBundle\Action
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class ParametersReadAction extends AbstractAction implements AdminActionInterface
{
    use BreadcrumbTrait;
    use TemplatingTrait;

    private SchemaRegistryInterface $schemaRegistry;
    private SettingManagerInterface $settingManager;


    /**
     * Constructor.
     *
     * @param SettingManagerInterface $settingManager
     * @param SchemaRegistryInterface $schemaRegistry
     */
    public function __construct(
        SettingManagerInterface $settingManager,
        SchemaRegistryInterface $schemaRegistry
    ) {
        $this->settingManager = $settingManager;
        $this->schemaRegistry = $schemaRegistry;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(): Response
    {
        $this->addBreadcrumbItem([
            'label'        => 'parameter.label.plural',
            'trans_domain' => 'EkynaSetting',
        ]);

        $settings = [];

        foreach ($this->schemaRegistry->getSchemas() as $namespace => $schema) {
            $settings[$namespace] = $this->settingManager->loadSettings($namespace);
        }

        return $this->render($this->options['template'], [
            'context'   => $this->context,
            'settings'  => $settings,
            'labels'    => $this->settingManager->getLabels(),
            'templates' => $this->settingManager->getShowTemplates(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function configureAction(): array
    {
        return [
            'permission' => Permission::READ,
            'route'      => [
                'name'    => 'admin_%s_read',
                'path'    => '',
                'methods' => 'GET',
            ],
            'button'     => [
                'label' => 'button.show',
                'theme' => 'default',
                'icon'  => 'eye',
            ],
            'options'    => [
                'template' => '@EkynaSetting/Admin/Parameter/read.html.twig',
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public static function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('template')
            ->setAllowedTypes('template', 'string');
    }
}
