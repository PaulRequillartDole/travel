<?php

namespace App\Controller;

use App\Entity\Voyage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;


#[Route(path: '/map')]
class MapController extends AbstractController
{
    #[Route(path: '', name: 'app_map', methods: ['GET'])]
    public function __invoke(): Response
    {
        $voyages = $this->getUser()->getVoyages();
        $myMap = (new Map())->fitBoundsToMarkers();

        /** @var Voyage $voyage */
        foreach ($voyages as $voyage) {
            if ($voyage->getStatus()->getId() === 4 && $voyage->getLat()){
                $myMap
                    ->addMarker(new Marker(
                        position: new Point(floatval($voyage->getLat()), floatval($voyage->getLon())),
                        title: $voyage->getDestination(),
                        infoWindow: new InfoWindow(
                            content: '<p>'.$voyage->getDestination().'</p><p>'.$voyage->getDescription().'</p>',
                        )
                    ));
            }
        }

        if (count($myMap->toArray()['markers']) === 1){
            $myMap->center(new Point($myMap->toArray()['markers'][0]['position']['lat'], $myMap->toArray()['markers'][0]['position']['lng']));
            $myMap->zoom(2);
            $myMap->fitBoundsToMarkers(false);
        }

        return $this->render('map/index.html.twig', [
            'map' => $myMap,
        ]);
    }
}
