<?php
namespace App\Controller;

use App\Entity\Castle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Chateaux extends AbstractController
{
    /**
     * @Route("/chateaux", name="chateaux")
     */
    public function chateaux(): Response
    {
        // Récupère le dépôt lié à la classe Castle
        $repo = $this->getDoctrine()
            ->getRepository(Castle::class);

        // Exécute une requête SELECT
        $castles = $repo->findAll();

        // Utilisation du résultat
        return $this->render('castle/index.html.twig', [
            'castles' => $castles
        ]);
    }

    /**
     * @Route("/chateau/{id}", name="chateau_readone", requirements={"id"="\d+"})
     * @param int $id
     * @return Response
     */
    public function chateau(int $id): Response
    {
        $repo = $this->getDoctrine()
            ->getRepository(Castle::class);

        $castles = $repo->findAll();
        $castle  = $repo->find($id);

        if (!$castle) {
            return $this->redirectToRoute('chateaux');
        }

        return $this->render('chateau.html.twig', [
            'chateaux' => $castles,
            'chateau' => $castle
        ]);
    }
}