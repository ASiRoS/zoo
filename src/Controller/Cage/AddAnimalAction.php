<?php

declare(strict_types=1);

namespace App\Controller\Cage;

use App\Controller\AbstractController;
use App\Controller\Service\Factory\AnimalFactory;
use App\Entity\Cage;
use App\Request\AddAnimal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AddAnimalAction extends AbstractController
{
    /**
     * @Route("/cage/{id}/animal")
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $type = $this->get('type', '');
        $id = $this->request->get('id');

        $violations = $validator->validate(new AddAnimal($type));

        if ($violations->count() > 0) {
            return $this->errors($violations);
        }

        /** @var Cage|null $cage */
        $cage = $entityManager->getRepository(Cage::class)->find($id);

        if (!$cage) {
            $this->createNotFoundException(sprintf('Cage with %s is not found.', $id));
        }

        $animal = AnimalFactory::create($type);
        $cage->add($animal);

        $entityManager->persist($animal);
        $entityManager->flush();

        return $this->response($cage);
    }
}
