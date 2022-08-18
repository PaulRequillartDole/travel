<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Voyage;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class NoteController extends AbstractController
{
    /**
     * @Route("/voyage/{id}/note/new", name="app_note_new", methods={"GET", "POST"})
     */
    public function new(Voyage $voyage, Request $request, NoteRepository $noteRepository): Response
    {
        $note = new Note();
        $note->setVoyage($voyage);
        $note->setAuthor($this->getUser());
        $form = $this->createForm(NoteType::class, $note, ['action' => $this->generateUrl('app_note_new', ['id' => $voyage->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noteRepository->add($note, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->renderForm('note/new.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/note/{id}", name="app_note_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/note/{id}/edit", name="app_note_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Note $note, NoteRepository $noteRepository): Response
    {
        $form = $this->createForm(NoteType::class, $note, ['action' => $this->generateUrl('app_note_edit', ['id' => $note->getId()])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noteRepository->add($note, true);

            return $this->redirectToRoute('app_voyage_show', ['id' => $note->getVoyage()->getId()]);
        }

        return $this->renderForm('note/edit.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/note/{id}/show-delete", name="app_note_show_delete", methods={"GET", "POST"})
     */
    public function showDelete(Note $note): Response
    {
        return $this->render('note/delete.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/note/{id}/delete", name="app_note_delete", methods={"POST"})
     */
    public function delete(Request $request, Note $note, NoteRepository $noteRepository): Response
    {
        $voyage = $note->getVoyage();
        if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
            $noteRepository->remove($note, true);
        }

        return $this->redirectToRoute('app_voyage_show', ['id' => $voyage->getId()], Response::HTTP_SEE_OTHER);
    }
}
