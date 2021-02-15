<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class AddAnimal
{
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @Assert\Choice({"lion", "crocodile", "elephant"})
     */
    public string $type;
}
