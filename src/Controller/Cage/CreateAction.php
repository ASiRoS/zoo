<?php

declare(strict_types=1);

namespace App\Controller\Cage;

use App\Controller\AbstractController;
use App\Entity\Cage;
use App\Request\CreateCage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateAction extends AbstractController
{
    /**
     * @Route("cage", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $type = $this->get('type', '');

        $violations = $validator->validate(
            new CreateCage($type)
        );

        if ($violations->count() > 0) {
            return $this->errors($violations);
        }

        $cage = new Cage($type);

        $entityManager->persist($cage);
        $entityManager->flush();

        return $this->response($cage, Response::HTTP_CREATED);
    }
}
