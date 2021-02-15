<?php

declare(strict_types=1);

namespace App\Entity\Animal;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
final class Lion extends Animal
{
    public const TYPE = 'lion';

    public function eat(string $what): string
    {
        return "I eat $what";
    }

    public function growl(): string
    {
        return 'Roaaaar!';
    }
}
