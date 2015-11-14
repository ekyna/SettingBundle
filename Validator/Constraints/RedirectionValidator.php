<?php

namespace Ekyna\Bundle\SettingBundle\Validator\Constraints;

use Buzz\Browser;
use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class RedirectionValidator
 * @package Ekyna\Bundle\SettingBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var HttpUtils
     */
    private $httpUtils;

    /**
     * @var Browser
     */
    private $browser;


    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     * @param HttpUtils    $httpUtils
     */
    public function __construct(RequestStack $requestStack, HttpUtils $httpUtils)
    {
        $this->requestStack = $requestStack;
        $this->httpUtils    = $httpUtils;
        $this->browser      = new Browser();
    }

    /**
     * {@inheritdoc}
     */
    public function validate($redirection, Constraint $constraint)
    {
        if (! $constraint instanceof Redirection) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Redirection');
        }
        if (! $redirection instanceof RedirectionInterface) {
            throw new UnexpectedTypeException($redirection, 'Ekyna\Bundle\SettingBundle\Model\RedirectionInterface');
        }

        if (0 < strlen($fromPath = $redirection->getFromPath())) {
            if ($redirection->getFromPath() == $redirection->getToPath()) {
                $this->context->addViolationAt('toPath', $constraint->infiniteLoop);
                return;
            }

            if ('/' !== $fromPath[0]) {
                $this->context->addViolationAt('fromPath', $constraint->badFormat);
            } elseif ($this->isPathAccessible($fromPath)) {
                $this->context->addViolationAt('fromPath', $constraint->fromPathExists);
            }
        }

        if (0 < strlen($toPath = $redirection->getToPath())) {
            if ('/' !== $toPath[0]) {
                $this->context->addViolationAt('toPath', $constraint->badFormat);
            } elseif (!$this->isPathAccessible($toPath)) {
                $this->context->addViolationAt('toPath', $constraint->toPathNotFound);
            }
        }
    }

    /**
     * Returns whether the given path is accessible through http or not.
     *
     * @param $path
     * @return bool
     */
    private function isPathAccessible($path)
    {
        $uri = $this->httpUtils->generateUri($this->requestStack->getMasterRequest(), $path);

        /** @var \Buzz\Message\Response $res */
        $res = $this->browser->get($uri);
        if ($res->isSuccessful()) {
            return true;
        }

        return false;
    }
}
