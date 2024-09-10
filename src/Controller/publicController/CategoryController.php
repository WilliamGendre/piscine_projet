<?php

declare(strict_types=1);

namespace App\Controller\publicController;

use App\Repository\CategoryRepository;
use App\Repository\IllustrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController{

    #[Route('/categoryAll', name: 'category_all')]
    public function listCategory(CategoryRepository $categoryRepository)
    {
        return $this->render('publicView/page/public/listCategory.html.twig', ['categorys' => $categoryRepository->findAll()]);
    }

    #[Route('/OneCategory/{id}', name: 'one_category')]
    public function oneIllustration(int $id, IllustrationRepository $illustrationsRepository, CategoryRepository $categoryRepository){
        $category = $categoryRepository->find($id);
        $illustrations = [];

        if (!$category) {
            return $this->render('publicView/error404.html.twig');
        }

        $illustrations = $illustrationsRepository->findByCategory($category);

        return $this->render('publicView/page/public/oneCategory.html.twig', ['category' => $category, 'illustrations' => $illustrations]);
    }

}