<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Weapon;
use App\Form\WeaponType;




final class WeaponController extends AbstractController
{

    #[Route('/weapon', name: 'app_weapon_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $weapons = $entityManager->getRepository(Weapon::class)->findAll();

        return $this->render('weapon/index.html.twig', [
            'weapons' => $weapons,
        ]);
        
    }    

    #[Route('/weapon/new', name: 'app_weapon_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response{
        $weapon = new Weapon();
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($weapon);
            $entityManager->flush();

            $this->addFlash('success', 'Arma creada con éxito.');

            return $this->redirectToRoute('app_weapon_index');
    }
    return $this->render('weapon/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
