<?php

namespace Ekyna\Bundle\SettingBundle\Controller;

use Buzz\Browser;
use Ekyna\Bundle\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HelperController
 * @package Ekyna\Bundle\SettingBundle\Controller
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class HelperController extends Controller
{
    /**
     * Fetches the helper content.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fetchAction(Request $request)
    {
        $reference = strtoupper($request->query->get('reference', null));
        $remote = (bool)$request->query->get('remote', 1);

        if (0 < strlen($reference) && $remote) {
            $remoteEndPoints = $this->container->getParameter('ekyna_setting.helper_remotes');
            foreach ($remoteEndPoints as $remoteEndPoint) {
                // remote=0 prevent infinite loop/recursion
                $url = $remoteEndPoint . '?reference=' . $reference . '&remote=0';
                $headers = $request->headers->all();
                if (null !== $response = $this->getRemoteResponse($url, $headers)) {
                    return $response;
                }
            }
        }

        $ttl = 7 * 24 * 3600;
        $response = new Response();
        $response
            ->setPublic()
            ->headers->add(array('Content-Type' => 'application/xml; charset=utf-8'))
        ;

        if (0 < strlen($reference)) {
            $repository = $this->getDoctrine()->getRepository('EkynaSettingBundle:Helper');
            if (null !== $helper = $repository->findOneBy(array('reference' => $reference))) {
                $response->setLastModified($helper->getUpdatedAt());
                if ($response->isNotModified($request)) {
                    return $response;
                }
                $response->setContent($this->renderView('EkynaSettingBundle:Helper:show.xml.twig', array(
                    'helper' => $helper,
                )));
                return $this->configureSharedCache($response, array($helper->getEntityTag()), $ttl);
            }
        }

        $expires = new \DateTime();
        $expires->modify('+7 days');
        return $response
            ->setMaxAge($ttl)
            ->setExpires($expires)
            ->setContent($this->renderView('EkynaSettingBundle:Helper:show.xml.twig'))
        ;
    }

    /**
     * Sends a http request to a remote server and returns a (symfony) response on success or null on failure.
     *
     * @param string $url
     * @param array $headers
     * @return null|Response
     */
    protected function getRemoteResponse($url, array $headers = array())
    {
        $fixedHeaders = array('connection' => 'close');
        foreach($headers as $key => $header) {
            if (is_int($key)) {
                list($key, $header) = explode(':', $header);
            }
            $key = strtolower($key);
            if (in_array($key, array('cache-control', 'accept', 'user-agent', 'accept-encoding', 'accept-language'))) {
                if (is_array($header)) {
                    $fixedHeaders[$key] = implode('; ', $header);
                }
            }
        }

        $browser = new Browser();
        /** @var \Buzz\Message\Response $res */
        $res = $browser->get($url, $fixedHeaders);
        if ($res->isSuccessful()) {
            $response = new Response($res->getContent(), $res->getStatusCode());
            $headers = [];
            foreach($res->getHeaders() as $header) {
                if (0 < strpos($header, ':')) {
                    list($key, $value) = explode(':', $header);
                    $headers[trim($key)] = trim($value);
                }
            }
            $response->headers->add($headers);
            return $response;
        }

        return null;
    }
}
