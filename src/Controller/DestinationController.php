<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Entity\Voyage;
use App\Form\DestinationEditType;
use App\Form\DestinationType;
use App\Service\GeocodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DestinationController extends AbstractController
{
    #[Route('/voyage/{id}/destination/new', name: 'app_destination_new')]
    public function new(Voyage $voyage, Request $request, EntityManagerInterface $entityManager, GeocodeService $geocodeService)
    {
        $destination = new Destination();
        $destination->setVoyage($voyage);

        $form = $this->createForm(DestinationType::class, $destination, [
            'action' => $this->generateUrl('app_destination_new', ['id' => $voyage->getId()]),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $geocodeService->getGeoData($destination->getTitle());
            if ($data){
                $destination->setLat($data->getLatitude());
                $destination->setLng($data->getLongitude());
                $entityManager->persist($destination);
                $entityManager->flush();
            }else{
                $this->addFlash('danger', [
                    'content' => 'Erreur lors de la récupération des données GPS.',
                    'title' => 'Erreur.'
                ]);
            }

            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->render('destination/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/voyage/{id}/destination/{destination}/edit', name: 'app_destination_edit')]
    public function edit(Voyage $voyage, Destination $destination, Request $request, EntityManagerInterface $entityManager, GeocodeService $geocodeService)
    {

        $form = $this->createForm(DestinationEditType::class, $destination, [
            'action' => $this->generateUrl('app_destination_edit', ['id' => $voyage->getId(), 'destination' => $destination->getId()]),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($destination);
            $entityManager->flush();

            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->render('destination/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }
}