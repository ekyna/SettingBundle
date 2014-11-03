<?php

namespace Ekyna\Bundle\SettingBundle\Controller\Admin;

use Ekyna\Bundle\AdminBundle\Controller\Resource\ToggleableTrait;
use Ekyna\Bundle\AdminBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class HelperController
 * @package Ekyna\Bundle\SettingBundle\Controller\Admin
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class HelperController extends ResourceController
{
    use ToggleableTrait;

    public function tinymceAction(Request $request)
    {
        if(null === $field = $request->attributes->get('field')) {
            throw new AccessDeniedHttpException('Field parameter is mandatory.');
        }

        $context = $this->loadContext($request);
        $resourceName = $this->config->getResourceName();
        if(null === $resource = $context->getResource($resourceName)) {
            throw new \RuntimeException('Resource not found.');
        }

        $this->isGranted('VIEW', $resource);

        $propertyAcessor = PropertyAccess::createPropertyAccessor();
        $content = $propertyAcessor->getValue($resource, $field);

        return $this->render('EkynaSettingBundle:Helper/Admin:tinymce.html.twig', array(
            'content' => $content
        ));
    }
}
