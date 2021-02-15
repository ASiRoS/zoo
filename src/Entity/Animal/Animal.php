<?php

declare(strict_types=1);

namespace App\Entity\Animal;

use App\Entity\Cage;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Exception;

/**
 * @ORM\MappedSuperclass
 *
 * @ORM\Entity
 * @ORM\Table(name="animal")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"lion" = "Lion", "crocodile" = "Crocodile", "elephant"="Elephant"})
 */
abstract class Animal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cage", inversedBy="animals")
     */
    protected Cage $cage;

    abstract public function eat(string $what): string;

    public function changeCage(Cage $cage): void
    {
        $this->cage = $cage;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        if (!defined('static::TYPE')) {
            throw new Exception('Animal must have type!');
        }

        return static::TYPE;
    }
}
