<?php

declare(strict_types=1);

namespace Symkit\MenuBundle\Contract;

use Symkit\MenuBundle\Entity\MenuItem;
use Symkit\MenuBundle\Service\MenuModelFactory;

/**
 * Public API for mapping menu item entities to models (BC-safe, semver).
 * Implement this interface and tag your service with symkit_menu.menu_item_mapper.
 */
interface MenuItemMapperInterface
{
    public function supports(MenuItem $entity): bool;

    public function map(MenuItem $entity, MenuModelFactory $factory): MenuItemInterface;
}
