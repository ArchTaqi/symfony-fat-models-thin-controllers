<?php declare(strict_types=1);

namespace App\EventListener;

use App\Event\RepositoryEvent;
use App\Entity\BadWord;

/**
 * Class BadWordListener
 * @package App\EventListener
 */
class BadWordListener
{
    /**
     * @var RepositoryEvent
     */
    protected $event;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * BadWordListener constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param RepositoryEvent $event
     */
    public function preValidate(RepositoryEvent $event)
    {
        if (!$event->getData() instanceof BadWord
            || $event->getAction() !== 'create'
        ) {
            return ;
        }
        $this->logger->debug('BadWordListener preValidate');
        $this->event = $event;
    }

    /**
     * @param RepositoryEvent $event
     */
    public function onPreFlush(RepositoryEvent $event)
    {
        if (!$event->getData() instanceof BadWord
            || $event->getAction() !== 'create'
        ) {
            return ;
        }
        $this->logger->debug('BadWordListener onPostFlush');
        $this->event = $event;
    }

    /**
     * @param RepositoryEvent $event
     */
    public function onPostFlush(RepositoryEvent $event)
    {
        if (!$event->getData() instanceof BadWord
            || $event->getAction() !== 'create'
        ) {
            return ;
        }
        $this->logger->debug('BadWordListener onPostFlush');
        $this->event = $event;
    }
}
