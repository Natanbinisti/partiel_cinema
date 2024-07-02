<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Image;
use App\Form\FilmType;
use App\Form\ImageType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmController extends AbstractController
{
    #[Route('/', name: 'app_film')]
    public function index(FilmRepository $filmRepository): Response
    {
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'films' => $filmRepository->findAll(),
        ]);
    }
    #[Route('/film/{id}', name: 'app_film_show',priority: -1)]
    public function show(Film $film, Request $request, EntityManagerInterface $manager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image->setFilm($film);
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute('app_film_show', ['id' => $film->getId()]);
        }
        return $this->render('film/show.html.twig', [
            "film" => $film,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/film/create', name: 'app_film_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute('app_film');
        }
        return $this->render('film/create.html.twig', [
            'controller_name' => 'FilmController',
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/film/{id}/edit', name: 'app_film_edit') ]
    public function edit(Film $film, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute('app_film');
        }
        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/film/{id}/delete', name: 'app_film_delete') ]
    public function delete(Film $film, EntityManagerInterface $manager): Response
    {
        $manager->remove($film);
        $manager->flush();
        return $this->redirectToRoute('app_film');
    }

    #[Route('/image/delete/{id}', name: 'app_film_image_delete')]
    public function deleteImageFilm(Image $image, EntityManagerInterface $manager) : Response
    {
        $manager->remove($image);
        $manager->flush();

        return $this->redirectToRoute('app_film');
    }

}
