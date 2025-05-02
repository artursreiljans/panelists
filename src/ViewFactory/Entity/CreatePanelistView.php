<?php

declare(strict_types=1);

namespace App\ViewFactory\Entity;

use App\Controller\Panelist\PanelistDeleteController;
use App\Controller\Panelist\PanelistShowController;
use App\Controller\Panelist\PanelistUpdateController;
use App\Entity\Panelist;
use App\View\Element\CountryView;
use App\View\Element\LinksView;
use App\View\Element\LinkView;
use App\View\Element\StatusView;
use App\View\Entity\PanelistView;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class CreatePanelistView
{
    public function __construct(
        private TranslatorInterface $translator,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function call(Panelist $panelist): PanelistView
    {
        $createLink = fn(string $route, string $name): LinkView => new LinkView(
            $this->urlGenerator->generate(
                $route,
                ['id' => $panelist->id],
                UrlGeneratorInterface::ABSOLUTE_URL,
            ),
            $this->translator->trans($name),
        );

        return new PanelistView(
            $panelist->firstName,
            $panelist->lastName,
            \sprintf('%s %s', $panelist->firstName, $panelist->lastName),
            $panelist->email,
            $panelist->phone,
            $panelist->createdAt,
            new StatusView(
                $this->translator->trans(
                    $panelist->isSubscribed
                        ? 'subscription_status.active'
                        : 'subscription_status.inactive',
                )
            ),
            new CountryView(
                Countries::getName(
                    $panelist->country,
                    $this->translator->getLocale(),
                ),
            ),
            new LinksView(
                view:   $createLink(
                            PanelistShowController::class,
                            'actions.view',
                        ),
                edit:   $createLink(
                            PanelistUpdateController::class,
                            'actions.edit'
                        ),
                delete: $createLink(
                            PanelistDeleteController::class,
                            'actions.delete',
                        ),
            )
        );
    }
}
