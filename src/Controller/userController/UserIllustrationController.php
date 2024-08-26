<?php

namespace App\Controller\userController;

use App\Entity\Illustration;
use App\Form\IllustrationType;
use App\Repository\IllustrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserIllustrationController extends AbstractController
{

    // Affichage d'une illustration
    #[Route('/illustrationHome/{id}', name: 'public_illustration')]
    public function oneIllustration(int $id, IllustrationRepository $illustrationRepository){
        $illustration = $illustrationRepository->find($id);
        return $this->render('publicView/page/public/oneIllustration.html.twig', ['illustration' => $illustration]);
    }

    #[Route('/user/illustration/{id}', name: 'user_illustration_one')]
    public function oneIllustrationByUser(int $id, IllustrationRepository $illustrationRepository){
        $currentUser = $this->getUser();
        $illustration = $illustrationRepository->find($id);
        return $this->render('user/page/oneIllustrationByUser.html.twig', ['illustration' => $illustration, 'user' => $currentUser]);
    }

    // Ajout d'une nouvelle illustration par l'utilsateur
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

    // Modification d'une illustration par son utilisateur
    #[Route ('/user/update/illustration/{id}', name: 'user_update_illustration')]
    public function updateIllustrationUser(int $id, IllustrationRepository $illustrationRepository, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, ParameterBagInterface $params){

        $currentUser = $this->getUser();

        $illustration = $illustrationRepository->find($id);

        if ($illustration->getUser() !== $currentUser){
            return $this->render('user/page/accesInterdit.html.twig');
        }

        $illustrationUpdateForm = $this->createForm(IllustrationType::class, $illustration);
        $thumbnailUpdateForm = $this->createForm(IllustrationType::class, $illustration);

        $illustrationUpdateForm->handleRequest($request);
        $thumbnailUpdateForm->handleRequest($request);

        if($illustrationUpdateForm->isSubmitted() && $illustrationUpdateForm->isValid()) {

            $illustrationFile = $illustrationUpdateForm->get('illustration')->getData();
            $thumbnail = $thumbnailUpdateForm->get('thumbnail')->getData();

            if ($illustrationFile !== null) {
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
                $illustration->setUpdatedAt(new \DateTime('now'));

                $entityManager->persist($illustration);
                $entityManager->flush();

                $this->addFlash('success', 'L\'illustration à bien été modifié');
            }
        }

        return $this->render('user/page/updateIllustration.html.twig', ['illustrationUpdateForm' => $illustrationUpdateForm->createView()]);
    }

    #[Route ('user/delete/illustration/{id}', name: 'user_delete_illustration')]
    public function deleteIllustration(int $id, IllustrationRepository $illustrationRepository, EntityManagerInterface $entityManager){

        $currentUser = $this->getUser();

        $illustration = $illustrationRepository->find($id);

        if ($illustration->getUser() !== $currentUser){
            return $this->render('user/page/accesInterdit.html.twig');
        }

        $entityManager->remove($illustration);
        $entityManager->flush();

        return $this->redirectToRoute('user_home');
    }
}