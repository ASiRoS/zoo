<?php

declare(strict_types=1);

namespace App\Entity\Animal;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
final class Crocodile extends Animal
{
    public const TYPE = 'crocodile';

    public function eat(string $what): string
    {
        return 'Crocodile is eating.';
    }

    public function swim(): string
    {
        return 'Crocodile is swimming';
    }
}
