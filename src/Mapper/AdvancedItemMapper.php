<?php

declare(strict_types=1);

namespace Symkit\MenuBundle\Mapper;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symkit\MenuBundle\Entity\MenuItem;
use Symkit\MenuBundle\Model\MenuAdvancedItem;
use Symkit\MenuBundle\Model\MenuItemInterface;
use Symkit\MenuBundle\Service\MenuModelFactory;
use Throwable;

final readonly class AdvancedItemMapper implements MenuItemMapperInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function supports(MenuItem $entity): bool
    {
        return MenuItem::TYPE_ADVANCED_ITEM === $entity->getType();
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

        return new MenuAdvancedItem(
            id: $entity->getIdentifier() ?? (string) $entity->getId(),
            label: $entity->getLabel() ?? '',
            description: $entity->getDescription() ?? '',
            url: $url,
            icon: $entity->getIcon(),
        );
    }
}
