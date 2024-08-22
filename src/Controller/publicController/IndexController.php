<?php

declare(strict_types=1);

namespace App\Controller\publicController;

use App\Entity\Illustration;
use App\Repository\IllustrationRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController{

    #[Route('/', name: 'index')]
    public function homePage(IllustrationRepository $illustrationRepository){

        $currentUser = $this->getUser();

        $illustrations = $illustrationRepository->findByIllustrationHome();

        // regarde si un user est connecter
        if (null !== $currentUser && $this->isGranted('ROLE_USER')) {
            return $this->render('user/indexUser.html.twig', ['illustrations' => $illustrations]);
        }
        return $this->render('publicView/index.html.twig', ['illustrations' => $illustrations]);
    }

}