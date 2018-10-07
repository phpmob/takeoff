<?php

declare(strict_types=1);

namespace Chang\Standard\Tests;

use Psr\Log\LoggerInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

class FakeMailSender implements SenderInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function send(string $code, array $recipients, array $data = [], array $attachments = [], array $replyTo = []): void
    {
        $this->logger->info(sprintf('FakeMailSender: %s', $code), $recipients);
    }
}
