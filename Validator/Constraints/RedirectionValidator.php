<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Validator\Constraints;

use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
    private RequestStack $requestStack;
    private HttpUtils    $httpUtils;
    private Client       $client;


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
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Redirection) {
            throw new UnexpectedTypeException($constraint, Redirection::class);
        }
        if (!$value instanceof RedirectionInterface) {
            throw new UnexpectedTypeException($value, RedirectionInterface::class);
        }

        if (!empty($fromPath = $value->getFromPath())) {
            if ($value->getFromPath() == $value->getToPath()) {
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

        if (!empty($toPath = $value->getToPath())) {
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
    private function isPathAccessible(string $path): bool
    {
        $uri = $this->httpUtils->generateUri($this->requestStack->getMainRequest(), $path);

        try {
            $res = $this->client->request('GET', $uri);
            if (200 <= $res->getStatusCode() && $res->getStatusCode() <= 302) {
                return true;
            }
        } catch (GuzzleException $e) {
        }

        return false;
    }
}
