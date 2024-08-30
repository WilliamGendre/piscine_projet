<?php

declare(strict_types=1);

namespace App\Controller\publicController;

use App\Repository\IllustrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController{

    #[Route('/', name: 'index')]
    public function homePage(IllustrationRepository $illustrationRepository){

        $illustrations = $illustrationRepository->findByIllustrationHome();

        return $this->render('publicView/index.html.twig', ['illustrations' => $illustrations]);
    }

    #[Route('/illustration/{id}', name: 'home_illustration')]
    public function oneIllustrationHome(int $id, IllustrationRepository $illustrationRepository){
        $illustration = $illustrationRepository->find($id);

        if (!$illustration) {
            return $this->render('publicView/error404.html.twig');
        }

        return $this->render('user/page/oneIllustration.html.twig', ['illustration' => $illustration]);
    }

}