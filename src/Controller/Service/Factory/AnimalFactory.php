<?php

declare(strict_types=1);

namespace App\Controller\Service\Factory;

use App\Entity\Animal\Animal;
use App\Entity\Cage;

final class AnimalFactory
{
    public static function create(string $type): Animal
    {
        $class = Cage::TYPES[$type];

        return new $class;
    }
}
