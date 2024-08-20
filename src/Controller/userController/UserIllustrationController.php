<?php

namespace App\Controller\userController;

use App\Entity\Illustrations;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserIllustrationController extends AbstractController
{

    #[Route('/user/insert/illustration', name: 'user_insert_illustration')]
    public function insertIllustration(Request $request, EntityManagerInterface $entityManager){

        if($request->isMethod('POST')){
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $thumbnail = $request->request->get('thumbnail');
            $illustrationFile = $request->request->get('illustration');

            if(!$name){
                $this->addFlash('fail', 'Il manque le nom de l\'illustration');
                return $this->render('user/page/insertIllustration.html.twig');
            }

            if(!$description){
                $this->addFlash('fail', 'Il manque la description de l\'illustration');
                return $this->render('user/page/insertIllustration.html.twig');
            }

            if(!$thumbnail){
                $this->addFlash('fail', 'Il manque l\'image de l\'illustration');
                return $this->render('user/page/insertIllustration.html.twig');
            }

            if(!$illustrationFile){
                $this->addFlash('fail', 'Il manque le fichier de l\'illustration');
                return $this->render('user/page/insertIllustration.html.twig');
            }

            $illustration = new Illustrations();

            $illustration->setName($name);
            $illustration->setDescription($description);
            $illustration->setThumbnail($thumbnail);
            $illustration->setIllustration($illustrationFile);
            $illustration->setUser($this->getUser());

            $entityManager->persist($illustration);
            $entityManager->flush();

            $this->addFlash('success', 'L\'illustration à bien été créé');
        }

        return $this->render('user/page/insertIllustration.html.twig');
    }
}