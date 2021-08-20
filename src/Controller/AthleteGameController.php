<?php

namespace App\Controller;

use App\Entity\AthleteGame;
use App\Services\AthleteGameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AthleteGameController extends AbstractController
{
    protected AthleteGameService $athleteGameService;
    protected SerializerInterface $serializer;
    

    public function __construct(
        AthleteGameService $athleteGameService,
        SerializerInterface $serializer
    ) {
        $this->athleteGameService = $athleteGameService;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $method = $request->getMethod();
        $uri = explode('/', $request->getRequestUri());
        $id = (int) end($uri);
        $data = $this->serializer->deserialize($request->getContent(), AthleteGame::class, 'json');

        // if the service return an instance of AthleteGame it means that validation has been passed, otherwise catch the exception message and return it
        $validate = $this->athleteGameService->validateData($data);
        if (!$validate instanceof(AthleteGame::class)) {
            return $this->json($validate, 400);
        }
        
        switch ($method) {
            case 'POST':
                $result = $this->athleteGameService->create($data);
                break;
            case 'PATCH':
                $result = $this->athleteGameService->update($id, $data);
                break;
            default:
                return $this->json('Bad Request', 400);
                break;
        }
        
        // if the service return an instance of AthleteGame it means that data has been correctly saved in the DB, otherwise catch the exception message and return it
        if (!$result instanceof(AthleteGame::class)) {
            return $this->json($result, 400);
        } else {
            return $this->json($result, 200);
        }
    }
}
