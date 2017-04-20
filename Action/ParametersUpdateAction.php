<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Action;

use Ekyna\Bundle\AdminBundle\Action\AbstractFormAction;
use Ekyna\Bundle\ResourceBundle\Action\RegistryTrait;
use Ekyna\Bundle\ResourceBundle\Service\Routing\RoutingUtil;
use Ekyna\Bundle\SettingBundle\Manager\SettingManagerInterface;
use Ekyna\Bundle\SettingBundle\Schema\SchemaRegistryInterface;
use Ekyna\Bundle\UiBundle\Form\Type\FormActionsType;
use Ekyna\Component\Resource\Action\Permission;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Exception\ValidatorException;

use function Symfony\Component\Translation\t;

/**
 * Class ParametersUpdateAction
 * @package Ekyna\Bundle\SettingBundle\Action
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class ParametersUpdateAction extends AbstractFormAction
{
    use RegistryTrait;

    private SettingManagerInterface $settingManager;
    private SchemaRegistryInterface $schemaRegistry;

    public function __construct(
        SettingManagerInterface $settingManager,
        SchemaRegistryInterface $schemaRegistry
    ) {
        $this->schemaRegistry = $schemaRegistry;
        $this->settingManager = $settingManager;
    }

    public function __invoke(): Response
    {
        $cancelRoute = RoutingUtil::getRouteName(
            $this->context->getConfig(),
            $this->getActionRegistry()->find(ParametersReadAction::class)
        );

        $form = $this->buildForm($cancelRoute);

        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                foreach ($this->schemaRegistry->getSchemas() as $namespace => $schema) {
                    $this->settingManager->saveSettings($namespace, $form->get($namespace)->getData());
                }

                $this->addFlash(t('parameter.flash.edit', [], 'EkynaSetting'), 'success');
            } catch (ValidatorException $exception) {
                $this->addFlash(t($exception->getMessage(), [], 'validators'), 'danger');
            }

            return $this->redirectToRoute($cancelRoute);
        }

        $this->addBreadcrumbItem([
            'label'        => 'parameter.label.plural',
            'trans_domain' => 'EkynaSetting',
            'action'       => ParametersReadAction::class,
        ]);
        $this->addBreadcrumbItem([
            'route' => false,
        ]);

        return $this->render($this->options['template'], [
            'context'   => $this->context,
            'labels'    => $this->settingManager->getLabels(),
            'templates' => $this->settingManager->getFormTemplates(),
            'form'      => $form->createView(),
        ]);
    }

    private function buildForm(string $cancelRoute): FormInterface
    {
        $data = [];
        foreach ($this->schemaRegistry->getSchemas() as $namespace => $schema) {
            $data[$namespace] = $this->settingManager->loadSettings($namespace);
        }

        $builder = $this
            ->createFormBuilder($data, [
                'action'      => $this->generateResourcePath(
                    $this->context->getConfig()->getId(),
                    self::class
                ),
                'method'      => 'POST',
                'attr'        => [
                    'class' => 'form-horizontal form-with-tabs',
                ],
                'data_class'  => null,
                'constraints' => [new Valid()],
            ])
            ->add('actions', FormActionsType::class, [
                'buttons' => [
                    'save'   => [
                        'type'    => Type\SubmitType::class,
                        'options' => [
                            'label'        => t('button.save', [], 'EkynaUi'),
                            'button_class' => 'primary',
                            'attr'         => [
                                'icon' => 'ok',
                            ],
                        ],
                    ],
                    'cancel' => [
                        'type'    => Type\ButtonType::class,
                        'options' => [
                            'label'        => t('button.cancel', [], 'EkynaUi'),
                            'button_class' => 'default',
                            'as_link'      => true,
                            'attr'         => [
                                'class' => 'form-cancel-btn',
                                'icon'  => 'remove',
                                'href'  => $this->generateUrl($cancelRoute),
                            ],
                        ],
                    ],
                ],
            ]);

        foreach ($this->schemaRegistry->getSchemas() as $namespace => $schema) {
            $builder->add($namespace, get_class($schema));
        }

        return $builder->getForm()->setData($data);
    }

    public static function configureAction(): array
    {
        return [
            'permission' => Permission::UPDATE,
            'route'      => [
                'name'    => 'admin_%s_update',
                'path'    => '/update',
                'methods' => ['GET', 'POST'],
            ],
            'button'     => [
                'label' => 'button.edit',
                'theme' => 'warning',
                'icon'  => 'pencil',
            ],
            'options'    => [
                'template' => '@EkynaSetting/Admin/Parameter/update.html.twig',
            ],
        ];
    }

    public static function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('template')
            ->setAllowedTypes('template', 'string');
    }
}
