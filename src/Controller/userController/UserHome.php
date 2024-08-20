<?php

declare(strict_types=1);

namespace App\Controller\userController;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class UserHome extends AbstractController{

    #[Route('/user', name:'user_home')]
    public function userHome(){
        return $this->render('user/page/userHome.html.twig');
    }
}