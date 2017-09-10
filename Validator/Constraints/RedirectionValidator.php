<?php

namespace Ekyna\Bundle\SettingBundle\Validator\Constraints;

use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class RedirectionValidator
 * @package Ekyna\Bundle\SettingBundle\Validator\Constraints
 * @author  Étienne Dauvergne <contact@ekyna.com>
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
     * @var Client
     */
    private $client;


    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     * @param HttpUtils    $httpUtils
     */
    public function __construct(RequestStack $requestStack, HttpUtils $httpUtils)
    {
        $this->requestStack = $requestStack;
        $this->httpUtils = $httpUtils;
        $this->client = new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function validate($redirection, Constraint $constraint)
    {
        if (!$constraint instanceof Redirection) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\Redirection');
        }
        if (!$redirection instanceof RedirectionInterface) {
            throw new UnexpectedTypeException($redirection, 'Ekyna\Bundle\SettingBundle\Model\RedirectionInterface');
        }

        if (0 < strlen($fromPath = $redirection->getFromPath())) {
            if ($redirection->getFromPath() == $redirection->getToPath()) {
                $this->context
                    ->buildViolation($constraint->infiniteLoop)
                    ->atPath('toPath')
                    ->addViolation();

                return;
            }

            if ('/' !== $fromPath[0]) {
                $this->context
                    ->buildViolation($constraint->badFormat)
                    ->atPath('fromPath')
                    ->addViolation();
            } elseif ($this->isPathAccessible($fromPath)) {
                $this->context
                    ->buildViolation($constraint->fromPathExists)
                    ->atPath('fromPath')
                    ->addViolation();
            }
        }

        if (0 < strlen($toPath = $redirection->getToPath())) {
            if ('/' !== $toPath[0]) {
                $this->context
                    ->buildViolation($constraint->badFormat)
                    ->atPath('toPath')
                    ->addViolation();
            } elseif (!$this->isPathAccessible($toPath)) {
                $this->context
                    ->buildViolation($constraint->toPathNotFound)
                    ->atPath('toPath')
                    ->addViolation();
            }
        }
    }

    /**
     * Returns whether the given path is accessible through http or not.
     *
     * @param string $path
     *
     * @return bool
     */
    private function isPathAccessible($path)
    {
        $uri = $this->httpUtils->generateUri($this->requestStack->getMasterRequest(), $path);

        try {
            $res = $this->client->request('GET', $uri);
            if (200 <= $res->getStatusCode() && $res->getStatusCode() <= 302) {
                return true;
            }
        } catch (RequestException $e) {
        }

        return false;
    }
}
