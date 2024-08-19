<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Place;
use App\Entity\Section;
use App\Entity\User;
use App\Entity\Voyage;
use App\Form\VoyageBannerType;
use App\Form\VoyageStatusType;
use App\Form\VoyageType;
use App\Form\VoyageUserType;
use App\Repository\VoyageRepository;
use App\Service\GeocodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

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
        $status = [];
        $myMap = (new Map())->fitBoundsToMarkers();

        /** @var Voyage $voyage */
        foreach ($voyages as $voyage) {
            $voyagesByStatus[$voyage->getStatus()->getLabel()][] = $voyage;
            $status[$voyage->getStatus()->getLabel()] = $voyage->getStatus();
            if ($voyage->getStatus()->getId() === 4 && $voyage->getLat()){
                $myMap
                    ->addMarker(new Marker(
                        position: new Point(floatval($voyage->getLat()), floatval($voyage->getLon())),
                        title: $voyage->getDestination()
                    ));
            }
        }

        if (count($myMap->toArray()['markers']) === 1){
            $myMap->center(new Point($myMap->toArray()['markers'][0]['position']['lat'], $myMap->toArray()['markers'][0]['position']['lng']));
            $myMap->zoom(2);
            $myMap->fitBoundsToMarkers(false);
        }

        return $this->render('voyage/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
            'voyagesByStatus' => $voyagesByStatus,
            'status' => $status,
            'map' => $myMap,
        ]);
    }

    /**
     * @Route("/new", name="app_voyage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VoyageRepository $voyageRepository, GeocodeService $geocodeService): Response
    {
        $voyage = new Voyage();
        /** @var User $user */
        $user = $this->getUser();
        $voyage->setOwner($user);
        $form = $this->createForm(VoyageType::class, $voyage, [
            'user' => $user,
            'action' => $this->generateUrl('app_voyage_new'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coordonates = $geocodeService->getCoordinates($voyage->getDestination());
            if ($coordonates){
                $voyage->setLat($coordonates['latitude']);
                $voyage->setLon($coordonates['longitude']);
            }
            $voyageRepository->add($voyage, true);

            //return to voyage
            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
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
    public function edit(Request $request, Voyage $voyage, VoyageRepository $voyageRepository, GeocodeService $geocodeService): Response
    {
        if (!$this->isGranted('VOYAGE_EDIT', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        $user = $this->getUser();
        $form = $this->createForm(VoyageType::class, $voyage, [
            'user' => $user,
            'action' => $this->generateUrl('app_voyage_edit', ['id' => $voyage->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coordonates = $geocodeService->getCoordinates($voyage->getDestination());
            if ($coordonates){
                $voyage->setLat($coordonates['latitude']);
                $voyage->setLon($coordonates['longitude']);
            }
            $voyageRepository->add($voyage, true);

            //return to voyage
            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->renderForm('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/status", name="app_voyage_status", methods={"GET", "POST"})
     */
    public function status(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        if (!$this->isGranted('VOYAGE_EDIT', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        $user = $this->getUser();
        $form = $this->createForm(VoyageStatusType::class, $voyage, [
            'action' => $this->generateUrl('app_voyage_status', ['id' => $voyage->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage, true);

            //return to voyage
            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->renderForm('voyage/edit_status.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/users", name="app_voyage_users", methods={"GET", "POST"})
     */
    public function users(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        if (!$this->isGranted('VOYAGE_EDIT', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        $user = $this->getUser();
        $form = $this->createForm(VoyageUserType::class, $voyage, [
            'user' => $user,
            'action' => $this->generateUrl('app_voyage_users', ['id' => $voyage->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage, true);

            //return to voyage
            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->renderForm('voyage/edit_users.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/banner", name="app_voyage_banner", methods={"GET", "POST"})
     */
    public function banner(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        if (!$this->isGranted('VOYAGE_EDIT', $voyage)) {
            $this->addFlash('danger', ['title' => 'Vous n\'avez pas le droit d\'accéder à cette page']);
            return $this->redirectToRoute('app_voyage_index');
        }

        $user = $this->getUser();
        $form = $this->createForm(VoyageBannerType::class, $voyage, [
            'action' => $this->generateUrl('app_voyage_banner', ['id' => $voyage->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage, true);

            //return to voyage
            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->renderForm('voyage/edit_banner.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/voyage/{id}/show-delete", name="app_voyage_show_delete", methods={"GET", "POST"})
     */
    public function showDelete(Voyage $voyage): Response
    {
        return $this->render('voyage/delete.html.twig', [
            'voyage' => $voyage,
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
