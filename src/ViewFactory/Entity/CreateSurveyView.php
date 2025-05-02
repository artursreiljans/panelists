<?php

declare(strict_types=1);

namespace App\ViewFactory\Entity;

use App\Controller\Survey\SurveyDeleteController;
use App\Controller\Survey\SurveyShowController;
use App\Controller\Survey\SurveyUpdateController;
use App\Entity\Survey;
use App\View\Element\LinksView;
use App\View\Element\LinkView;
use App\View\Element\StatusView;
use App\View\Entity\SurveyView;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class CreateSurveyView
{
    public function __construct(
        private TranslatorInterface $translator,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function call(Survey $survey): SurveyView
    {
        $createLink = fn(string $route, string $name): LinkView => new LinkView(
            $this->urlGenerator->generate(
                $route,
                ['id' => $survey->id],
                UrlGeneratorInterface::ABSOLUTE_URL,
            ),
            $this->translator->trans($name),
        );

        return new SurveyView(
            $survey->name,
            $survey->createdAt,
            new StatusView(
                $this->translator->trans(
                    $survey->isActive ? 'status.active' : 'status.inactive',
                ),
            ),
            new LinksView(
                view:   $createLink(
                            SurveyShowController::class,
                            'actions.view',
                        ),
                edit:   $createLink(
                            SurveyUpdateController::class,
                            'actions.edit',
                        ),
                delete: $createLink(
                            SurveyDeleteController::class,
                            'actions.delete',
                        ),
            )
        );
    }
}
