<?php

namespace App\Controller\Admin;

use App\Entity\Candy;
use App\Repository\CandyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/article', 'admin_article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        return $this->render('admin/article/index.html.twig');
    }

    #[Route('/create', name:'create')]
    public function create(EntityManagerInterface $em){

        $candy=new Candy();
        $candy->setName('Sucette')
        ->setSlug('fraise')
        ->setDescription('Un super bonbon')
        ->setCreateAt(new DateTimeImmutable());

        $em->persist($candy);
        $em->flush();
        dd($candy);

        return $this->render('admin/article/create.html.twig');
    }

    #[Route('/update/{id}', name:'update', requirements:['id'=>Requirement::DIGITS])]
    public function update($id, CandyRepository $repository, EntityManagerInterface $em){

        // find() permet de récupérer un enregistrement de la basse de données grace a son id.
        // $candy = $repository->find(1);

        // findAll() permet de récupérer tous les enregistrement de la basse de données.
        // $candy = $repository->findAll();

        // findBy() permet de récupérer tous les enregistrement de la basse de données correspondant a des conditions sur les champs
        // $candy = $repository->findBy(['name'=>'Sucette']);

        //  findOneBy() permet de recuperer le premier enregistrement de la base de données correspondant à des conditions sur les champs
        // $candy = $repository->findOneBy(['slug' => 'fraise','name' => 'Sucette']);

        $candy = $repository->find($id);

        $candy->setName('fraise');
        $em->flush();

        return $this->render('admin/article/update.html.twig');
    }

    #[Route('/delete/{id}', name:'delete', requirements:['id'=>Requirement::DIGITS])]
    public function delete(){
        return $this->render('admin/article/delete.html.twig');
    }
}