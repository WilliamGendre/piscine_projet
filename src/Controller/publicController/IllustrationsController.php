<?php

declare(strict_types=1);

namespace App\Controller\publicController;

use App\Repository\IllustrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class IllustrationsController extends AbstractController{

    #[Route('/illustrations/all', name: 'illustration_all')]
    public function illustrationAll(IllustrationRepository $illustrationRepository){

        $illustrations = $illustrationRepository->findall();

        return $this->render('publicView/page/public/illustrations.html.twig', ['illustrations' => $illustrations]);
    }
}