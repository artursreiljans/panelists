<?php

declare(strict_types=1);

namespace App\Twig;

use App\Controller\Panelist\PanelistIndexController;
use App\Controller\Survey\SurveyIndexController;
use App\View\Element\LinkView;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

final class TwigGlobals extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly TranslatorInterface $translator,
        #[Autowire(param: 'app_title')]
        private readonly string $appTitle,
    ) {
    }

    public function getGlobals(): array
    {
        return [
            'appTitle' => $this->appTitle,
            'menu' => [
                $this->createLink(
                    PanelistIndexController::class,
                    'panelist.list',
                ),
                $this->createLink(
                    SurveyIndexController::class,
                    'survey.list',
                ),
            ],
        ];
    }

    private function createLink(string $route, string $name): LinkView
    {
        return new LinkView(
            $this->urlGenerator->generate(
                $route,
                [],
                UrlGeneratorInterface::ABSOLUTE_URL,
            ),
            $this->translator->trans($name),
        );
    }
}
