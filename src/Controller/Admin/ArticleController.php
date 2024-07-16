<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/article', 'admin_article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        return $this->render('admin/article/index.html.twig');
    }

    #[Route('/create', name:'create')]
    public function create(){
        return $this->render('admin/article/create.html.twig');
    }
}