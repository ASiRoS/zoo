<?php

declare(strict_types=1);

namespace App\Entity\Animal;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="elephant")
 */
final class Elephant extends Animal
{
    public const TYPE = 'elephant';

    public function eat(string $what): string
    {
        return 'Elephant is eating.';
    }

    public function shower(): string
    {
        return 'Elephant is showering itself.';
    }
}
