<?php

namespace Ekyna\Bundle\SettingBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * SettingsController
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Controller/SettingsController.php
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SettingsController extends Controller
{
    /**
     * Edit configuration with given namespace.
     *
     * @param Request $request
     * @param string  $namespace
     *
     * @return Response
     */
    public function editAction(Request $request, $namespace = null)
    {
        $manager = $this->getSettingsManager();
        $settings = $manager->loadSettings($namespace);

        $form = $this
            ->getSettingsFormFactory()
            ->create($namespace)
        ;

        $form->setData($settings);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $messageType = 'success';
            try {
                $manager->saveSettings($namespace, $form->getData());
                $message = $this->getTranslator()->trans('ekyna_setting.parameter.flash.edit');
            } catch (ValidatorException $exception) {
                $message = $this->getTranslator()->trans($exception->getMessage(), array(), 'validators');
                $messageType = 'error';
            }
            $request->getSession()->getFlashBag()->add($messageType, $message);

            if ($request->headers->has('referer')) {
                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render($request->attributes->get('template', 'EkynaSettingBundle:Settings:edit.html.twig'), array(
            'settings' => $settings,
            'form'     => $form->createView()
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
     * Get settings form factory
     *
     * @return \Ekyna\Bundle\SettingBundle\Manager\SettingsFormFactoryInterface
     */
    protected function getSettingsFormFactory()
    {
        return $this->get('ekyna_setting.form_factory');
    }

    /**
     * Get translator
     *
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->get('translator');
    }
}
