<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voyage")
 */
class VoyageController extends AbstractController
{
    /**
     * @Route("/", name="app_voyage_index", methods={"GET"})
     */
    public function index(VoyageRepository $voyageRepository): Response
    {
        $voyages = $this->getUser()->getVoyages();
        $voyagesByStatus = [];
        foreach ($voyages as $voyage) {
            $voyagesByStatus[$voyage->getStatus()->getLabel()][] = $voyage;
        }

        return $this->render('voyage/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
            'voyagesByStatus' => $voyagesByStatus,
        ]);
    }

    /**
     * @Route("/new", name="app_voyage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VoyageRepository $voyageRepository): Response
    {
        $voyage = new Voyage();
        /** @var User $user */
        $user = $this->getUser();
        $voyage->setOwner($user);
        $form = $this->createForm(VoyageType::class, $voyage, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage, true);

            return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_voyage_show", methods={"GET"})
     */
    public function show(Voyage $voyage): Response
    {
        if (!$this->isGranted('VOYAGE_SHOW', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_voyage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        if (!$this->isGranted('VOYAGE_EDIT', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        $user = $this->getUser();
        $form = $this->createForm(VoyageType::class, $voyage, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage, true);

            return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_voyage_delete", methods={"POST"})
     */
    public function delete(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        if (!$this->isGranted('VOYAGE_EDIT', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        if ($this->isCsrfTokenValid('delete'.$voyage->getId(), $request->request->get('_token'))) {
            $voyageRepository->remove($voyage, true);
        }

        return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
    }
}
