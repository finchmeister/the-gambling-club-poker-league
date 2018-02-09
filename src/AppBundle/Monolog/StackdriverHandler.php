<?php


namespace AppBundle\Monolog;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class StackdriverHandler
 * @package AppBundle\Monolog
 * @link https://stackoverflow.com/questions/41676196/google-cloud-stackdriver-and-monolog-symfony
 */
class StackdriverHandler extends PsrHandler
{
    /**
     * @var LoggerInterface[]
     */
    protected $loggers;

    /**
     * @var LoggingClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $name;

    /**
     * StackdriverHandler constructor.
     *
     * @param LoggerInterface $projectId
     * @param bool            $name
     * @param bool|int        $level
     * @param bool            $bubble
     */
    public function __construct($projectId, $gcpKeyFilePath, $name = 'main', $level = Logger::DEBUG, $bubble = true)
    {
        $this->client = new LoggingClient(
            [
                'projectId' => $projectId,
                'keyFilePath' => $gcpKeyFilePath,
            ]
        );

        $this->name   = $name;
        $this->level  = $level;
        $this->bubble = $bubble;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $record)
    {
        if (!$this->isHandling($record)) {
            return false;
        }

        $this->getLogger($record['channel'])->log(strtolower($record['level_name']), $record['message'], $record['context']);

        return false === $this->bubble;
    }

    /**
     * @param $channel
     *
     * @return LoggerInterface
     */
    protected function getLogger($channel)
    {
        if (!isset($this->loggers[$channel])) {
            $this->loggers[$channel] = $this->client->psrLogger($this->name, ['labels' => ['context' => $channel]]);
        }

        return $this->loggers[$channel];
    }
}