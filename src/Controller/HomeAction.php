<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cage;
use App\Repository\CageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeAction extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     * @Route("/cage", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        /** @var CageRepository $repository */
        $repository = $entityManager->getRepository(Cage::class);

        /** @var Cage[] $cages */
        $cages = $repository->findAll();

        return $this->response($cages);
    }
}
