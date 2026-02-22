<?php

declare(strict_types=1);

namespace Symkit\MenuBundle\Service;

use Symkit\MenuBundle\Contract\MenuItemInterface;
use Symkit\MenuBundle\Entity\MenuItem as MenuItemEntity;
use Symkit\MenuBundle\Mapper\MenuItemMapperInterface;

final readonly class MenuModelFactory
{
    /**
     * @param iterable<MenuItemMapperInterface> $mappers
     */
    public function __construct(
        private iterable $mappers,
    ) {
    }

    public function createModel(MenuItemEntity $entity): ?MenuItemInterface
    {
        foreach ($this->mappers as $mapper) {
            if ($mapper->supports($entity)) {
                return $mapper->map($entity, $this);
            }
        }

        return null;
    }
}
