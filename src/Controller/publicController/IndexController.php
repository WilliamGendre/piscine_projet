<?php

declare(strict_types=1);

namespace App\Controller\publicController;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController{

    #[Route('/', name: 'index')]
    public function homePage(){
        $currentUser = $this->getUser();
        // regarde si un user est connecter
        if (null !== $currentUser && $this->isGranted('ROLE_USER')) {
            return $this->render('user/indexUser.html.twig');
        }
        return $this->render('publicView/index.html.twig');
    }

}