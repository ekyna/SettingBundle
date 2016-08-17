<?php

namespace Ekyna\Bundle\SettingBundle\Controller\Admin;

use Braincrafted\Bundle\BootstrapBundle\Form\Type\FormActionsType;
use Ekyna\Bundle\CoreBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class ParameterController
 * @package Ekyna\Bundle\SettingBundle\Controller\Admin
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class ParameterController extends Controller
{
    /**
     * Show the parameters.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        $this->isGranted('VIEW');

        $this->container->get('ekyna_admin.menu.builder')
            ->breadcrumbAppend('settings', 'ekyna_setting.parameter.label.plural');

        $manager = $this->getSettingsManager();
        $schemas = $this->getSettingsRegistry()->getSchemas();
        $settings = [];

        foreach ($schemas as $namespace => $schema) {
            $settings[$namespace] = $manager->loadSettings($namespace);
        }

        return $this->render('EkynaSettingBundle:Admin/Settings:show.html.twig', [
            'settings'  => $settings,
            'labels'    => $manager->getLabels(),
            'templates' => $manager->getShowTemplates(),
        ]);
    }

    /**
     * Edit the parameters.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $this->isGranted('EDIT');

        $this->container->get('ekyna_admin.menu.builder')
            ->breadcrumbAppend('settings', 'ekyna_setting.parameter.label.plural');

        $manager = $this->getSettingsManager();
        $schemas = $this->getSettingsRegistry()->getSchemas();

        $settings = [];
        $builder = $this
            ->createFormBuilder(null, [
                'action' => $this->generateUrl('ekyna_setting_parameter_admin_edit'),
                'method' => 'post',
                'attr' => [
                    'class' => 'form-horizontal form-with-tabs',
                ],
                'data_class'  => null,
                'admin_mode'  => true,
                'constraints' => [new Valid()],
            ])
            ->add('actions', FormActionsType::class, [
                'buttons' => [
                    'save'   => [
                        'type'    => Type\SubmitType::class,
                        'options' => [
                            'button_class' => 'primary',
                            'label'        => 'ekyna_core.button.save',
                            'attr'         => [
                                'icon' => 'ok',
                            ],
                        ],
                    ],
                    'cancel' => [
                        'type'    => Type\ButtonType::class,
                        'options' => [
                            'label'        => 'ekyna_core.button.cancel',
                            'button_class' => 'default',
                            'as_link'      => true,
                            'attr'         => [
                                'class' => 'form-cancel-btn',
                                'icon'  => 'remove',
                                'href'  => $this->generateUrl('ekyna_setting_parameter_admin_show'),
                            ],
                        ],
                    ],
                ],
            ]);
        foreach ($schemas as $namespace => $schema) {
            $builder->add($namespace, get_class($schema));
            $settings[$namespace] = $manager->loadSettings($namespace);
        }

        $form = $builder
            ->getForm()
            ->setData($settings);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $messageType = 'success';
            try {
                foreach ($schemas as $namespace => $schema) {
                    $manager->saveSettings($namespace, $form->get($namespace)->getData());
                }
                $message = $this->getTranslator()->trans('ekyna_setting.parameter.flash.edit');
            } catch (ValidatorException $exception) {
                $message = $this->getTranslator()->trans($exception->getMessage(), [], 'validators');
                $messageType = 'danger';
            }
            $this->addFlash($message, $messageType);

            return $this->redirect($this->generateUrl('ekyna_setting_parameter_admin_show'));
        }

        return $this->render('EkynaSettingBundle:Admin/Settings:edit.html.twig', [
            'labels'    => $manager->getLabels(),
            'templates' => $manager->getFormTemplates(),
            'form'      => $form->createView(),
        ]);
    }

    /**
     * Get settings manager
     *
     * @return \Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface
     */
    protected function getSettingsManager()
    {
        return $this->get('ekyna_setting.manager');
    }

    /**
     * Get settings registry
     *
     * @return \Ekyna\Bundle\SettingBundle\Schema\SchemaRegistryInterface
     */
    protected function getSettingsRegistry()
    {
        return $this->get('ekyna_setting.schema_registry');
    }

    /**
     * Checks if the attributes are granted against the current token.
     *
     * @param mixed      $attributes
     * @param mixed|null $object
     * @param bool       $throwException
     *
     * @throws AccessDeniedHttpException when the security context has no authentication token.
     *
     * @return bool
     */
    protected function isGranted($attributes, $object = null, $throwException = true)
    {
        if (is_null($object)) {
            $object = $this->getConfiguration()->getObjectIdentity();
        } else {
            $object = $this->get('ekyna_resource.configuration_registry')->getObjectIdentity($object);
        }
        if (!$this->get('security.authorization_checker')->isGranted($attributes, $object)) {
            if ($throwException) {
                throw new AccessDeniedHttpException('You are not allowed to view this resource.');
            }

            return false;
        }

        return true;
    }

    /**
     * Returns the configuration.
     *
     * @return \Ekyna\Component\Resource\Configuration\ConfigurationInterface
     */
    protected function getConfiguration()
    {
        return $this->get('ekyna_setting.parameter.configuration');
    }
}
