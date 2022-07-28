<?php

namespace App\Controller\Api;

use Throwable;
use App\Services\ShapeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShapesApiController
{
    #[Route('/api/v1/{shape}/{a_or_radius}/{b}/{c}')]
    public function shape($shape, $a_or_radius = null, $b = null, $c = null): Response
    {
        try {
            $shape = ShapeService::getInstance($shape);
            $shape->setAttributes($a_or_radius, $b, $c);
            $circumference = $shape->circumference();
            $surface = $shape->surface();

            $response = [
                "version" => "v1",
                "message" => "success",
                "data" => array_merge($shape->getAttributes(), [
                    "type" => $shape->getType(),
                    "surface" => $surface,
                    "circumference" => $circumference,
                ])
            ];

            return new JsonResponse($response);
        } catch (Throwable $throwable) {
            $response = [
                "version" => "v1",
                "message" => $throwable->getMessage(),
                "data" => null
            ];
            return new JsonResponse($response, 500);
        }
    }
}