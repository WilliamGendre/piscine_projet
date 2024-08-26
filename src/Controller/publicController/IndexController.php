<?php

declare(strict_types=1);

namespace App\Controller\publicController;

use App\Repository\IllustrationRepository;
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

    #[Route('/illustration/{id}', name: 'home_illustration')]
    public function oneIllustrationHome(int $id, IllustrationRepository $illustrationRepository){
        $illustration = $illustrationRepository->find($id);
        return $this->render('user/page/oneIllustration.html.twig', ['illustration' => $illustration]);
    }

}