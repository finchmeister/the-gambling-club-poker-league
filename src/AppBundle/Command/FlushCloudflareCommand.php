<?php

namespace AppBundle\Command;

use AppBundle\Cache\Cloudflare\Client as CloudflareClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FlushCloudflareCommand extends Command
{
    /**
     * @var CloudflareClient
     */
    private $cloudflareClient;

    public function __construct(
        CloudflareClient $cloudflareClient
    ) {
        $this->cloudflareClient = $cloudflareClient;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:flush-cloudflare')
            ->setDescription('Flushes the cache')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->cloudflareClient->clearEverything();
        $io->success('Cache flushed');
    }
}
