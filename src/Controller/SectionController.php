<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Section;
use App\Entity\Voyage;
use App\Form\SectionType;
use App\Repository\ItemRepository;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    #[Route(path: '/voyage/{id}/section/new', name: 'app_section_new', methods: ['GET', 'POST'])]
    public function new(Voyage $voyage, Request $request, SectionRepository $sectionRepository): Response
    {
        $section = new Section();
        $section->setVoyage($voyage);
        $form = $this->createForm(SectionType::class, $section, ['action' => $this->generateUrl('app_section_new', ['id' => $voyage->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->add($section, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('section/new.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route(path: '/section/{id}', name: 'app_section_show', methods: ['GET'])]
    public function show(Section $section): Response
    {
        return $this->render('section/show.html.twig', [
            'section' => $section,
        ]);
    }

    #[Route(path: '/section/{id}/edit', name: 'app_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Section $section, SectionRepository $sectionRepository): Response
    {
        $form = $this->createForm(SectionType::class, $section, ['action' => $this->generateUrl('app_section_edit', ['id' => $section->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sectionRepository->add($section, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $section->getVoyage()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('section/edit.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route(path: '/section/{id}/show-delete', name: 'app_section_show_delete', methods: ['GET', 'POST'])]
    public function showDelete(Section $section): Response
    {
        return $this->render('section/delete.html.twig', [
            'section' => $section,
        ]);
    }

    #[Route(path: '/section/{id}/delete', name: 'app_section_delete', methods: ['POST'])]
    public function delete(Request $request, Section $section, SectionRepository $sectionRepository, ItemRepository $itemRepository): Response
    {
        $voyage = $section->getVoyage();
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
            foreach ($section->getItems() as $item){
                $itemRepository->remove($item);
            }
            $sectionRepository->remove($section, true);
        }

        return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()], Response::HTTP_SEE_OTHER);
    }
}
