<?php

namespace App\Controller;

use App\Entity\Icon;
use App\Form\IconType;
use App\Repository\IconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/icon")
 */
class IconController extends AbstractController
{
    /**
     * @Route("/", name="app_icon_index", methods={"GET"})
     */
    public function index(IconRepository $iconRepository): Response
    {
        return $this->render('icon/index.html.twig', [
            'icons' => $iconRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_icon_new", methods={"GET", "POST"})
     */
    public function new(Request $request, IconRepository $iconRepository): Response
    {
        $icon = new Icon();
        $form = $this->createForm(IconType::class, $icon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $iconRepository->add($icon, true);

            return $this->redirectToRoute('app_icon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('icon/new.html.twig', [
            'icon' => $icon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_icon_show", methods={"GET"})
     */
    public function show(Icon $icon): Response
    {
        return $this->render('icon/show.html.twig', [
            'icon' => $icon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_icon_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Icon $icon, IconRepository $iconRepository): Response
    {
        $form = $this->createForm(IconType::class, $icon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $iconRepository->add($icon, true);

            return $this->redirectToRoute('app_icon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('icon/edit.html.twig', [
            'icon' => $icon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_icon_delete", methods={"POST"})
     */
    public function delete(Request $request, Icon $icon, IconRepository $iconRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$icon->getId(), $request->request->get('_token'))) {
            $iconRepository->remove($icon, true);
        }

        return $this->redirectToRoute('app_icon_index', [], Response::HTTP_SEE_OTHER);
    }
}
