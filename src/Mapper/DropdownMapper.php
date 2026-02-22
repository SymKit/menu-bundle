<?php

declare(strict_types=1);

namespace Symkit\MenuBundle\Mapper;

use Symkit\MenuBundle\Entity\MenuItem;
use Symkit\MenuBundle\Model\MenuDropdown;
use Symkit\MenuBundle\Model\MenuItemInterface;
use Symkit\MenuBundle\Service\MenuModelFactory;

final readonly class DropdownMapper implements MenuItemMapperInterface
{
    public function supports(MenuItem $entity): bool
    {
        return MenuItem::TYPE_DROPDOWN === $entity->getType();
    }

    public function map(MenuItem $entity, MenuModelFactory $factory): MenuItemInterface
    {
        $subItems = [];
        foreach ($entity->getChildren() as $child) {
            if ($childModel = $factory->createModel($child)) {
                $subItems[] = $childModel;
            }
        }

        return new MenuDropdown(
            id: $entity->getIdentifier() ?? (string) $entity->getId(),
            label: $entity->getLabel() ?? '',
            items: $subItems,
            icon: $entity->getIcon(),
        );
    }
}
