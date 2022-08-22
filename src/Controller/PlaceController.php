<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Place;
use App\Entity\Voyage;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    /**
     * @Route("/voyage/{id}/place/new", name="app_place_new", methods={"GET", "POST"})
     */
    public function new(Voyage $voyage, Request $request, PlaceRepository $placeRepository): Response
    {
        $place = new Place();
        $place->setVoyage($voyage);
        $form = $this->createForm(PlaceType::class, $place, ['action' => $this->generateUrl('app_place_new', ['id' => $voyage->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $placeRepository->add($place, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('place/new.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/place/{id}", name="app_place_show", methods={"GET"})
     */
    public function show(Place $place): Response
    {
        return $this->render('place/show.html.twig', [
            'place' => $place,
        ]);
    }

    /**
     * @Route("/place/{id}/edit", name="app_place_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Place $place, PlaceRepository $placeRepository): Response
    {
        $form = $this->createForm(PlaceType::class, $place, ['action' => $this->generateUrl('app_place_edit', ['id' => $place->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $placeRepository->add($place, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $place->getVoyage()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('place/edit.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    /**
    * @Route("/place/{id}/show-delete", name="app_place_show_delete", methods={"GET", "POST"})
    */
    public function showDelete(Place $place): Response
    {
        return $this->render('place/delete.html.twig', [
            'place' => $place,
        ]);
    }

    /**
     * @Route("/place/{id}/delete", name="app_place_delete", methods={"POST"})
     */
    public function delete(Request $request, Place $place, PlaceRepository $placeRepository): Response
    {
        $voyage = $place->getVoyage();
        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->request->get('_token'))) {
            $placeRepository->remove($place, true);
        }

        return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()], Response::HTTP_SEE_OTHER);
    }
}
