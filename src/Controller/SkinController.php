<?php

namespace App\Controller;

use App\Entity\Skin;
use App\Form\SkinType;
use App\Repository\SkinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/skin')]
final class SkinController extends AbstractController
{
    #[Route(name: 'app_skin_index', methods: ['GET'])]
    public function index(SkinRepository $skinRepository): Response
    {
        return $this->render('skin/index.html.twig', [
            'skins' => $skinRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_skin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $skin = new Skin();
        $form = $this->createForm(SkinType::class, $skin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Manejo de la imagen ANTES de persistir
            $imageFile = $form->get('imageFile')->getData();
            
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('skins_directory'),
                        $newFilename
                    );
                    $skin->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error al subir la imagen');
                }
            }

            // Una sola vez persist y flush
            $entityManager->persist($skin);
            $entityManager->flush();

            return $this->redirectToRoute('app_skin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('skin/new.html.twig', [
            'skin' => $skin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_skin_show', methods: ['GET'])]
    public function show(Skin $skin): Response
    {
        return $this->render('skin/show.html.twig', [
            'skin' => $skin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_skin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Skin $skin, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(SkinType::class, $skin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Manejo de la imagen ANTES del flush
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                // Eliminar imagen anterior si existe
                if ($skin->getImage()) {
                    $oldImagePath = $this->getParameter('skins_directory').'/'.$skin->getImage();
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('skins_directory'),
                        $newFilename
                    );
                    $skin->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Error al subir la imagen');
                }
            }

            // Una sola vez flush
            $entityManager->flush();

            return $this->redirectToRoute('app_skin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('skin/edit.html.twig', [
            'skin' => $skin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_skin_delete', methods: ['POST'])]
    public function delete(Request $request, Skin $skin, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skin->getId(), $request->getPayload()->getString('_token'))) {
            // Eliminar imagen al borrar skin
            if ($skin->getImage()) {
                $imagePath = $this->getParameter('skins_directory').'/'.$skin->getImage();
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $entityManager->remove($skin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_skin_index', [], Response::HTTP_SEE_OTHER);
    }
}