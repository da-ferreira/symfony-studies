<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SeriesWasCreated;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendNewSeriesEmailHandler
{
    public function __construct(private MailerInterface $mailer) {}

    public function __invoke(SeriesWasCreated $message)
    {
        $mockUsersEmails = ['johndoe@example.com', 'janedoe@example.com', 'fulano@example.com'];
        $seriesName = $message->series->getName();

        $email = (new Email())
            ->to(...$mockUsersEmails)
            ->subject('Nova série criada')
            ->text("Nova série criada: {$seriesName}")
            ->html("<p>Uma nova série foi criada: {$seriesName}</p>");

        $this->mailer->send($email);
    }
}
