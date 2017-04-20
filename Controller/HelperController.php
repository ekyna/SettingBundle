<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Controller;

use DateTime;
use Ekyna\Bundle\SettingBundle\Repository\HelperRepositoryInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

use function explode;
use function implode;
use function in_array;
use function is_array;
use function is_int;
use function strpos;
use function strtolower;
use function trim;

/**
 * Class HelperController
 * @package Ekyna\Bundle\SettingBundle\Controller
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class HelperController
{
    private HelperRepositoryInterface $repository;
    private Environment               $twig;
    private array                     $remotes;

    public function __construct(HelperRepositoryInterface $repository, Environment $twig, array $remotes)
    {
        $this->repository = $repository;
        $this->twig = $twig;
        $this->remotes = $remotes;
    }

    /**
     * Fetches the helper content.
     *
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function fetch(Request $request): Response
    {
        $reference = strtoupper($request->query->getAlnum('reference'));

        if (empty($reference)) {
            return new Response('Empty reference', Response::HTTP_BAD_REQUEST);
        }

        $useRemotes = $request->query->getBoolean('remote', true);

        if ($useRemotes) {
            foreach ($this->remotes as $remote) {
                // remote=0 prevent infinite loop/recursion
                $url = $remote . '?reference=' . $reference . '&remote=0';
                $headers = $request->headers->all();
                if (null !== $response = $this->getRemoteResponse($url, $headers)) {
                    return $response;
                }
            }
        }

        // TODO findByReference repository method
        if (null === $helper = $this->repository->findOneBy(['reference' => $reference])) {
            return new Response('Helper not found', Response::HTTP_NOT_FOUND);
        }

        $response = new Response();
        $response
            ->setPublic()
            ->setMaxAge(7 * 24 * 3600)
            ->setExpires(new DateTime('+7 days'))
            ->headers->add(['Content-Type' => 'application/xml; charset=utf-8']);

        $response->setLastModified($helper->getUpdatedAt());
        if ($response->isNotModified($request)) {
            return $response;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $response->setContent($this->twig->render('@EkynaSetting/Helper/show.xml.twig', [
            'helper' => $helper,
        ]));

        return $response;
    }

    /**
     * Sends a http request to a remote server and returns a (symfony) response on success or null on failure.
     *
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected function getRemoteResponse(string $url, array $headers = []): ?Response
    {
        $fixedHeaders = ['connection' => 'close'];
        foreach ($headers as $key => $header) {
            if (is_int($key)) {
                [$key, $header] = explode(':', $header);
            }
            $key = strtolower($key);
            if (in_array($key, ['cache-control', 'accept', 'user-agent', 'accept-encoding', 'accept-language'])) {
                if (is_array($header)) {
                    $fixedHeaders[$key] = implode('; ', $header);
                }
            }
        }

        $client = new Client();
        /** @var \GuzzleHttp\Psr7\Response $res */
        /** @noinspection PhpUnhandledExceptionInspection */
        $res = $client->request('GET', $url, $fixedHeaders);
        if (200 <= $res->getStatusCode() && $res->getStatusCode() < 300) {
            $response = new Response($res->getBody(), $res->getStatusCode());
            $headers = [];
            foreach ($res->getHeaders() as $header) {
                if (0 < strpos($header, ':')) {
                    [$key, $value] = explode(':', $header);
                    $headers[trim($key)] = trim($value);
                }
            }
            $response->headers->add($headers);

            return $response;
        }

        return null;
    }
}
