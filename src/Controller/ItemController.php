<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Item;
use App\Entity\Section;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/section/{id}/item/new", name="app_item_new", methods={"GET", "POST"})
     */
    public function new(Section $section, Request $request, ItemRepository $itemRepository): Response
    {
        $item = new Item();
        $item->setSection($section);
        $form = $this->createForm(ItemType::class, $item, ['action' => $this->generateUrl('app_item_new', ['id' => $section->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRepository->add($item, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $section->getvoyage()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/item/{id}", name="app_item_show", methods={"GET"})
     */
    public function show(Item $item): Response
    {
        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }

    /**
     * @Route("/item/{id}/edit", name="app_item_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        $form = $this->createForm(ItemType::class, $item, ['action' => $this->generateUrl('app_item_edit', ['id' => $item->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRepository->add($item, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $item->getSection()->getVoyage()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    /**
    * @Route("/item/{id}/show-delete", name="app_item_show_delete", methods={"GET", "POST"})
    */
    public function showDelete(Item $item): Response
    {
        return $this->render('item/delete.html.twig', [
            'item' => $item,
        ]);
    }

    /**
     * @Route("/item/{id}/delete", name="app_item_delete", methods={"POST"})
     */
    public function delete(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        $section = $item->getSection();
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $itemRepository->remove($item, true);
        }

        return $this->redirectToRoute('app_voyage_show', ['id' => $section->getvoyage()->getId()], Response::HTTP_SEE_OTHER);
    }
}
