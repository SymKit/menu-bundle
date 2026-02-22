<?php

declare(strict_types=1);

namespace Symkit\MenuBundle\Mapper;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symkit\MenuBundle\Entity\MenuItem;
use Symkit\MenuBundle\Model\MenuItemInterface;
use Symkit\MenuBundle\Model\MenuLink;
use Symkit\MenuBundle\Service\MenuModelFactory;
use Throwable;

final readonly class LinkMapper implements MenuItemMapperInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function supports(MenuItem $entity): bool
    {
        return MenuItem::TYPE_LINK === $entity->getType();
    }

    public function map(MenuItem $entity, MenuModelFactory $factory): MenuItemInterface
    {
        $url = $entity->getUrl() ?? '#';
        if ($entity->getRoute()) {
            try {
                $url = $this->urlGenerator->generate($entity->getRoute(), $entity->getOptions());
            } catch (Throwable) {
            }
        }

        return new MenuLink(
            id: $entity->getIdentifier() ?? (string) $entity->getId(),
            label: $entity->getLabel() ?? '',
            url: $url,
            icon: $entity->getIcon(),
        );
    }
}
