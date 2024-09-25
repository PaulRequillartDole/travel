<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Section;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route(path: '/', name: 'app')]
    public function index(VoyageRepository $voyageRepository, EntityManagerInterface $entityManager): Response
    {
//        if (($handle = fopen($this->getParameter('kernel.project_dir')."/note.csv", "r")) !== FALSE) {
//            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//                $voyage = $voyageRepository->find($data[1]);
//                $section = null;
//                if (count($voyage->getSections()) === 0){
//                    $section = (new Section())
//                        ->setTitle('Notes')
//                        ->setVoyage($voyage)
//                    ;
//                    $voyage->addSection($section);
//                    $entityManager->persist($section);
//                    $entityManager->flush();
//                }else{
//                    $section = $voyage->getSections()->last();
//                }
//
//                $item = (new Item())
//                    ->setTitle($data[3])
//                    ->setContent($data[4])
//                    ->setSection($section)
//                ;
//
//                $entityManager->persist($item);
//            }
//            $entityManager->flush();
//            fclose($handle);
//        }
//        die();

        return $this->redirectToRoute('app_voyage_index');
    }
}
