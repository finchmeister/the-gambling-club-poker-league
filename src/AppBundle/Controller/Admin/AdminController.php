<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Cache\RedisClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Cache\Cloudflare\Client as CloudflareClient;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function indexAction(): Response
    {
        return $this->render('admin/view.html.twig');
    }

    /**
     * @Route("/export", name="db_export")
     */
    public function exportDbAction(): BinaryFileResponse
    {
        return $this->file($this->getParameter('database_path'), 'poker.sqlite');
    }

    /**
     * @Route("/flush-redis", methods={"POST"}, name="flush_redis")
     */
    public function flushRedisAction(RedisClient $redisClient): Response
    {
        $redisClient->flushAll();
        $this->addFlash('success', 'Redis flushed');
        return $this->render('admin/view.html.twig');
    }

    /**
     * @Route("/flush-cloudflare", methods={"POST"}, name="flush_cloudflare")
     */
    public function flushCloudflareAction(CloudflareClient $client): Response
    {
        $client->clearEverything();
        $this->addFlash('success', 'Cloudflare cache flushed');
        return $this->render('admin/view.html.twig');
    }

}
