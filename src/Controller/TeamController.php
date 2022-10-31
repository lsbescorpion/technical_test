<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
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
class TeamController extends AbstractController
{
    /**
     * @Route("/team/list", name="team.list")
     */
    public function list(TeamRepository $teamRepository, SerializerInterface $serializer): JsonResponse
    {
        $teams = $teamRepository->findAll();
        return new JsonResponse([
            'teams' => $serializer->serialize($teams, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['players']])
        ]);
    }

    /**
     * @Route("/team/create", name="team_new", methods={"GET"})
     */
    public function create(): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team, [
        	'action' => $this->generateUrl('team_store'),
        ]);
        return $this->render('team/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/team/store", name="team.store", methods={"POST"})
     */
    public function store(Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent());
        $team = new Team();
        $team->setName($jsonData->name);
        $team->setHexColor($jsonData->hexColor);
        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->flush();
        return new JsonResponse([
            'message' => "OK"
        ]);
    }

    /**
     * @Route("/team/edit/{id}", name="team.edit", methods={"GET"})
     */
    public function edit(TeamRepository $teamRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        $team = $teamRepository->find($id);
        return new JsonResponse([
            'team' => $serializer->serialize($team, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['players']])
        ]);
    }

    /**
     * @Route("/team/update", name="team.update", methods={"POST"})
     */
    public function update(TeamRepository $teamRepository, Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent());
        $team = $teamRepository->find($jsonData->id);
        $team->setName($jsonData->name);
        $team->setHexColor($jsonData->hexColor);
	    $em = $this->getDoctrine()->getManager();
	    $em->flush();
	    return new JsonResponse([
            'message' => "OK"
        ]);
    }

    /**
     * @Route("/team/delete", name="team.delete", methods={"POST"})
     */
    public function delete(TeamRepository $teamRepository, Request $request): Response
    {
        $jsonData = json_decode($request->getContent());
    	$team = $teamRepository->find($jsonData);
        $em = $this->getDoctrine()->getManager();
        $em->remove($team);
	    $em->flush();
        return new JsonResponse([
            'message' => "OK"
        ]);
    }
}
