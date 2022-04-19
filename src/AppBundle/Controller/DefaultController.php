<?php

namespace App\AppBundle\Controller;

use App\AppBundle\Entity\Enclosure;
use App\AppBundle\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route ("/", name="homepage")
     */
    public function indexAction(Request $request, EntityManagerInterface $entityManager)
    {
        $enclosures = $entityManager->getRepository(Enclosure::class)
            ->findAll();

        return $this->render('default/index.html.twig', [
            'enclosures' => $enclosures
        ]);
    }

    /**
     * @Route("/grow", name="grow_dinosaur", methods={"POST"})
     */
    public function growAction(Request $request, DinosaurFactory $dinosaurFactory, EntityManagerInterface $entityManager)
    {
        $enclosure = $entityManager->getRepository(Enclosure::class)
            ->find($request->request->get('enclosure'));

        $specification = $request->request->get('specification');
        $dinosaur = $dinosaurFactory->growFromSpecification($specification);
        $dinosaur->setEnclosure($enclosure);
        $enclosure->addDinosaur($dinosaur);

        $entityManager->flush();

        $this->addFlash('success', sprintf(
            'Grew a %s in enclosure #%d',
            mb_strtolower($specification),
            $enclosure->getId()
        ));

        return $this->redirectToRoute('homepage');
    }
}
