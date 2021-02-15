<?php

declare(strict_types=1);

namespace App\Controller\Cage;

use App\Controller\AbstractController;
use App\Entity\Cage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ClearAction extends AbstractController
{
    /**
     * @Route("/cage/{id}/clear", methods={"POST"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $id = (int) $this->request->get('id');

        /** @var Cage|null $cage */
        $cage = $entityManager->getRepository(Cage::class)->find($id);

        if (!$cage) {
            $this->createNotFoundException(sprintf('Cage with %s is not found.', $id));
        }

        $cage->clear();

        $entityManager->persist($cage);
        $entityManager->flush();

        return $this->response($cage);
    }
}
