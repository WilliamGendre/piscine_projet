<?php

namespace App\Controller\userController;

use App\Entity\Illustration;
use App\Form\IllustrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserIllustrationController extends AbstractController
{

    #[Route('/user/insert/illustration', name: 'user_insert_illustration')]
    public function insertIllustration(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, ParameterBagInterface $params){

            $illustration = new Illustration();

            $illustrationCreatForm = $this->createForm(IllustrationType::class, $illustration);
            $thumbnailCreatForm = $this->createForm(IllustrationType::class, $illustration);

            $illustrationCreatForm->handleRequest($request);
            $thumbnailCreatForm->handleRequest($request);

            if($illustrationCreatForm->isSubmitted() && $illustrationCreatForm->isValid()) {

                $illustrationFile = $illustrationCreatForm->get('illustration')->getData();
                $thumbnail = $thumbnailCreatForm->get('thumbnail')->getData();

                if ($illustrationFile) {
                    $originalFileName = pathinfo($illustrationFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFileName = $slugger->slug($originalFileName);
                    $newFileName = $safeFileName . '-' . uniqid() . '.' . $illustrationFile->guessExtension();

                    $originalThumbnailFileName = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeThumbnailFileName = $slugger->slug($originalThumbnailFileName);
                    $newThumbnailFileName = $safeThumbnailFileName . '-' . uniqid() . '.' . $thumbnail->guessExtension();

                    $rootPath = $params->get("kernel.project_dir");
                    $illustrationFile->move($rootPath . '/public/uploadIllustration', $newFileName);

                    $rootPath = $params->get("kernel.project_dir");
                    $thumbnail->move($rootPath . '/public/uploadThumbnail', $newThumbnailFileName);

                    $illustration->setIllustration($newFileName);
                    $illustration->setThumbnail($newThumbnailFileName);
                    $illustration->setUser($this->getUser());

                    $entityManager->persist($illustration);
                    $entityManager->flush();

                    $this->addFlash('success', 'L\'illustration à bien été créé');
                }
            }

        return $this->render('user/page/insertIllustration.html.twig', ['illustrationForm' => $illustrationCreatForm->createView()]);
    }
}