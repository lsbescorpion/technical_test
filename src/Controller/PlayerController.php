<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
* @Route("/api")
*/
class PlayerController extends AbstractController
{
    /**
     * @Route("/player/list", name="player.list")
    */
    public function list(PlayerRepository $playerRepository, SerializerInterface $serializer): JsonResponse
    {
        $players = $playerRepository->findAll();
        return new JsonResponse([
            'players' => $serializer->serialize($players, 'json', [ 
                'circular_reference_handler' => function($object) {
                    return $object->getId();
                }
            ])
        ]);
    }

    public function create(): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player, [
        	'action' => $this->generateUrl('player_store'),
        ]);
        return $this->render('player/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/player/store", name="player.store", methods={"POST"})
     */
    public function store(TeamRepository $teamRepository, Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent());
        $player = new Player();
        $player->setName($jsonData->name);
        $player->setPosition($jsonData->position);
        $team = $teamRepository->find($jsonData->team);
        $player->setTeam($team);
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
        return new JsonResponse([
            'message' => "OK"
        ]);
    }

    /**
     * @Route("/player/edit/{id}", name="player.edit", methods={"GET"})
     */
    public function edit(PlayerRepository $playerRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        $player = $playerRepository->find($id);
        return new JsonResponse([
            'player' => $serializer->serialize($player, 'json', [
                'circular_reference_handler' => function($object) {
                    return $object->getId();
                }
            ])
        ]);
    }

    /**
     * @Route("/player/update", name="player.update", methods={"POST"})
     */
    public function update(PlayerRepository $playerRepository, TeamRepository $teamRepository, Request $request): Response
    {
        $jsonData = json_decode($request->getContent());
    	$player = $playerRepository->find($jsonData->id);
        $player->setName($jsonData->name);
        $player->setPosition($jsonData->position);
        $team = $teamRepository->find($jsonData->team->id);
        $player->setTeam($team);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return new JsonResponse([
            'message' => $jsonData
        ]);
    }

    /**
     * @Route("/player/delete", name="player.delete", methods={"POST"})
     */
    public function delete(PlayerRepository $playerRepository, Request $request): Response
    {
        $jsonData = json_decode($request->getContent());
        $player = $playerRepository->find($jsonData);
        $em = $this->getDoctrine()->getManager();
        $em->remove($player);
        $em->flush();
        return new JsonResponse([
            'message' => "OK"
        ]);
    }
}
