<?php

namespace App\Controller;

use App\Entity\Castle;
use App\Form\CastleType;
use App\Repository\CastleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/castle")
 */
class CastleController extends AbstractController
{
    /**
     * @Route("/", name="castle_index", methods={"GET"})
     */
    public function index(CastleRepository $castleRepository): Response
    {
        return $this->render('castle/index.html.twig', [
            'castles' => $castleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="castle_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $castle = new Castle();
        $form = $this->createForm(CastleType::class, $castle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($castle);
            $entityManager->flush();

            return $this->redirectToRoute('castle_index');
        }

        return $this->render('castle/new.html.twig', [
            'castle' => $castle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="castle_show", methods={"GET"})
     */
    public function show(Castle $castle): Response
    {
        return $this->render('castle/show.html.twig', [
            'castle' => $castle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="castle_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Castle $castle): Response
    {
        $form = $this->createForm(CastleType::class, $castle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('castle_index');
        }

        return $this->render('castle/edit.html.twig', [
            'castle' => $castle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="castle_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Castle $castle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$castle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($castle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('castle_index');
    }
}
