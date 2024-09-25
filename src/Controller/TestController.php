<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route(path: '/test', name: 'test_voyage_index', methods: ['GET'])]
    public function index(VoyageRepository $voyageRepository): Response
    {
        $voyages = $this->getUser()->getVoyages();
        $voyagesByStatus = [];
        $status = [];
        foreach ($voyages as $voyage) {
            $voyagesByStatus[$voyage->getStatus()->getLabel()][] = $voyage;
            $status[$voyage->getStatus()->getLabel()] = $voyage->getStatus();
        }
        return $this->render('test/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
            'voyagesByStatus' => $voyagesByStatus,
            'status' => $status,
        ]);
    }

    #[Route(path: '/test/new', name: 'test_voyage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VoyageRepository $voyageRepository): Response
    {
        $voyage = new Voyage();
        /** @var User $user */
        $user = $this->getUser();
        $voyage->setOwner($user);
        $form = $this->createForm(VoyageType::class, $voyage, [
            'user' => $user,
            'action' => $this->generateUrl('test_voyage_new'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage, true);

            return new JsonResponse([
                'status' => 'success',
                'row' => $this->renderView("voyage/_voyage.html.twig", [
                    'voyage' => $voyage
                ]),
                'type' => 'new'
            ]);
            //return to voyage
//            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->renderForm('test/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    #[Route(path: '/test/{id}/edit', name: 'test_voyage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        if (!$this->isGranted('VOYAGE_EDIT', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        $user = $this->getUser();
        $form = $this->createForm(VoyageType::class, $voyage, [
            'user' => $user,
            'action' => $this->generateUrl('test_voyage_edit', ['id' => $voyage->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage, true);

            return new JsonResponse([
                'status' => 'success',
                'row' => $this->renderView("voyage/_voyage.html.twig", [
                    'voyage' => $voyage
                ]),
                'type' => 'edit'
            ]);
            //return to voyage
//            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->renderForm('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }
}
