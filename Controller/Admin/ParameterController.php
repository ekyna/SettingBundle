<?php

namespace Ekyna\Bundle\SettingBundle\Controller\Admin;

use Ekyna\Bundle\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class ParameterController
 * @package Ekyna\Bundle\SettingBundle\Controller\Admin
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ParameterController extends Controller
{
    /**
     * Show the parameters.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request)
    {
        $this->container->get('ekyna_admin.menu.builder')
            ->breadcrumbAppend('settings', 'ekyna_setting.parameter.label.plural');
        
        $manager = $this->getSettingsManager();
        $schemas = $this->getSettingsRegistry()->getSchemas();
        $settings = [];

        foreach($schemas as $namespace => $schema) {
            $settings[$namespace] = $manager->loadSettings($namespace);
        }

        return $this->render($request->attributes->get('template', 'EkynaSettingBundle:Settings:show.html.twig'), array(
            'settings'   => $settings,
            'labels'     => $manager->getLabels(),
            'templates'  => $manager->getShowTemplates(),
        ));
    }

    /**
     * Edit the parameters.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $this->container->get('ekyna_admin.menu.builder')
            ->breadcrumbAppend('settings', 'ekyna_setting.parameter.label.plural');

        $manager = $this->getSettingsManager();
        $schemas = $this->getSettingsRegistry()->getSchemas();

        $settings = array();
        $builder = $this->createFormBuilder(null, array(
            'data_class' => null,
            'admin_mode' => true,
            '_footer' => array(
        	    'cancel_path' => $this->generateUrl('ekyna_setting_admin_show')
            ),
            'cascade_validation' => true,
        ));
        foreach($schemas as $namespace => $schema) {
            $builder->add($namespace, $schema);
            $settings[$namespace] = $manager->loadSettings($namespace);
        }

        $form = $builder
            ->getForm()
            ->setData($settings)
        ;

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $messageType = 'success';
            try {
                foreach($schemas as $namespace => $schema) {
                    $manager->saveSettings($namespace, $form->get($namespace)->getData());
                }
                $message = $this->getTranslator()->trans('ekyna_setting.parameter.flash.edit');
            } catch (ValidatorException $exception) {
                $message = $this->getTranslator()->trans($exception->getMessage(), array(), 'validators');
                $messageType = 'danger';
            }
            $this->addFlash($message, $messageType);

            return $this->redirect($this->generateUrl('ekyna_setting_admin_show'));
        }

        return $this->render($request->attributes->get('template', 'EkynaSettingBundle:Settings:edit.html.twig'), array(
            'labels'     => $manager->getLabels(),
            'templates'  => $manager->getFormTemplates(),
            'form'       => $form->createView(),
        ));
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
}
