<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Crocodile;
use App\Entity\Animal\Elephant;
use App\Entity\Animal\Lion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CageRepository")
 * @ORM\Table(name="cage")
 */
final class Cage
{
    /**
     * @var Collection|Animal[]
     * @ORM\OneToMany(targetEntity="App\Entity\Animal\Animal", mappedBy="cage", cascade={"persist"}, orphanRemoval=true)
     */
    private Collection $animals;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $type;

    public const TYPES = [
        Lion::TYPE => Lion::class,
        Elephant::TYPE => Elephant::class,
        Crocodile::TYPE => Crocodile::class,
    ];

    public function __construct(string $type, array $animals = [])
    {
        $this->animals = new ArrayCollection();
        $this->changeType($type);
        $this->fill($animals);
    }

    /**
     * @param array|Animal[] $animals
     */
    private function fill(array $animals): void
    {
        if (empty($animals)) {
            return;
        }

        foreach ($animals as $animal) {
            if (get_class($animal) !== self::TYPES[$this->type]) {
                throw new DomainException("Animal type can be only: $this->type");
            }

            $this->animals[] = $animal;
            $animal->changeCage($this);
        }
    }

    /**
     * @param array|Animal $animals
     */
    public function add($animals): void
    {
        if (is_object($animals)) {
            $animals = [$animals];
        }

        $this->fill($animals);
    }

    public function clear(): void
    {
        $this->animals->clear();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function changeType(string $type): void
    {
        $this->type = $type;
    }
}
