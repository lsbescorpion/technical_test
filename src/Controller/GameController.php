<?php

namespace App\Controller;

use App\Form\GameType;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
* @Route("/api")
*/
class GameController extends AbstractController
{
    /**
     * @Route("/game/random", name="game.random", methods={"GET"})
     */
    public function random(PlayerRepository $playerRepository, SerializerInterface $serializer): JsonResponse
    {
        $datos = $playerRepository->getSelectIds();
        $id = [];
        foreach ($datos as $key => $value) {
            array_push($id, $value['id']);
        }
        $keys = array_rand($id, 10);
        $ids = [];
        foreach ($keys as $key) {
            $ids[] = $id[$key];
        }
        $players = $playerRepository->getRandomPlayer($ids);
        shuffle($players);
        return new JsonResponse([
            'players' => $serializer->serialize($players, 'json', [ 
                'circular_reference_handler' => function($object) {
                    return $object->getId();
                }
            ])
        ]);
    }

    /**
     * @Route("/ajax-random-players", name="game_ajax_random_players", methods={"GET"})
     */
    public function ajaxRandomPlayers(PlayerRepository $playerRepository): Response
    {
        //TODO IN TECHNICAL TEST (endpoint logic)
    }
}