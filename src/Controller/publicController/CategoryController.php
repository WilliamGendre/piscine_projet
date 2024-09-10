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
}