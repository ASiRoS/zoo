<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

abstract class AbstractController
{
    private NormalizerInterface $normalizer;
    protected ?Request $request;

    public function __construct(NormalizerInterface $normalizer, RequestStack $requestStack)
    {
        $this->normalizer = $normalizer;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function response($data, int $status = 200): Response
    {
        return new JsonResponse($this->normalizer->normalize($data), $status);
    }

    /**
     *
     * @param ConstraintViolationInterface[]|ConstraintViolationListInterface $violations
     * @return Response
     */
    public function errors(ConstraintViolationListInterface $violations): Response
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return new JsonResponse(compact('errors'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function get(string $property, $default = null)
    {
        $data = $this->request->toArray();

        return $data[$property] ?? $default;
    }

    protected function createNotFoundException(string $message = 'Not Found', Throwable $previous = null): NotFoundHttpException
    {
        return new NotFoundHttpException($message, $previous);
    }
}
