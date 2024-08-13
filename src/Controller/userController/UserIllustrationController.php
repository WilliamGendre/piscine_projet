<?php

namespace App\Controller\userController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserIllustrationController extends AbstractController
{

    #[Route('/user/insertIllustration', name: 'user_insert_illustration')]
    public function insertIllustration(Request $request, EntityManagerInterface $entityManager){
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $name = $request->request->get('name');
        $name = $request->request->get('name');
        $name = $request->request->get('name');
    }
}