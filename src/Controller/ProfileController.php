<?php

namespace App\Controller;

use App\Entity\AdresseEmail;
use App\Entity\PaymentMethod;
use App\Form\AdresseEmailType;
use App\Form\PaymentMethodType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }


    #[Route('/profile/create/paymentmethod', name: 'app_create_paymentmethod', priority: 2)]
    public function createPaymentMethod(Request $request, EntityManagerInterface $manager): Response
    {
        $paymentMethod = new PaymentMethod();
        $form = $this->createForm(PaymentMethodType::class, $paymentMethod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $paymentMethod->setOwner($this->getUser());
            $manager->persist($paymentMethod);
            $manager->flush();
            return $this->redirectToRoute("app_profile");
        }

        return $this->render('profile/payment-create.html.twig', [
            "form"=>$form->createView(),
            "btnValue"=>"Ajouter"

        ]);
    }


    #[Route('/profile/delete/paymentmethod/{id}', name: 'app_delete_paymentmethod', priority: 2)]
    public function deletePaymentMethod(EntityManagerInterface $manager, PaymentMethod $paymentMethod): Response
    {
        $manager->remove($paymentMethod);
        $manager->flush();
        return $this->redirectToRoute("app_profile");
    }

    #[Route('/profile/edit/paymentmethod/{id}', name: 'app_edit_paymentmethod', priority: 4)]
    public function editPaymentMethod(Request $request, EntityManagerInterface $manager, PaymentMethod $paymentMethod):Response
    {
        $form = $this->createForm(PaymentMethodType::class, $paymentMethod);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $paymentMethod->setOwner($this->getUser());
            $manager->persist($paymentMethod);
            $manager->flush();
            return $this->redirectToRoute("app_profile");
        }

        return $this->render('profile/payment-create.html.twig', [
            "form"=>$form->createView(),
            "btnValue"=>"Editer"
        ]);

    }





























    #[Route('/profile/create/adresse_email', name: 'app_create_adresse_email', priority: 2)]
    public function createAdresseEmail(Request $request, EntityManagerInterface $manager): Response
    {
        $adresseemail = new AdresseEmail();
        $form = $this->createForm(AdresseEmailType::class, $adresseemail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $adresseemail->setOwner($this->getUser());
            $manager->persist($adresseemail);
            $manager->flush();
            return $this->redirectToRoute("app_profile");
        }

        return $this->render('profile/adresse-create.html.twig', [
            "form"=>$form->createView(),
            "btnValue"=>"Ajouter"

        ]);
    }


    #[Route('/profile/delete/adresse_email/{id}', name: 'app_delete_adresse_email', priority: 2)]
    public function deleteAdresseEmail(EntityManagerInterface $manager, AdresseEmail $adresseemail): Response
    {
        $manager->remove($adresseemail);
        $manager->flush();
        return $this->redirectToRoute("app_profile");
    }

    #[Route('/profile/edit/adresse_email/{id}', name: 'app_edit_adresse_email', priority: 4)]
    public function editAdresseEmail(Request $request, EntityManagerInterface $manager, AdresseEmail $adresseemail):Response
    {
        $form = $this->createForm(AdresseEmailType::class, $adresseemail);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $adresseemail->setOwner($this->getUser());
            $manager->persist($adresseemail);
            $manager->flush();
            return $this->redirectToRoute("app_profile");
        }

        return $this->render('profile/adresse-create.html.twig', [
            "form"=>$form->createView(),
            "btnValue"=>"Editer"
        ]);

    }
}