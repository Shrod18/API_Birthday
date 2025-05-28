<?php

namespace App\Controller;

use App\Entity\Birthday;
use App\Repository\BirthdayRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BirthdayController extends AbstractController
{
    /**
     * @Route("/birthday", name="app_birthday_list", methods={"GET"})
     */
    public function list(BirthdayRepository $birthdayRepository): JsonResponse
    {
        $birthdays = $birthdayRepository->findAll();
        return $this->json($birthdays);
    }

    /**
     * @Route("/birthday", name="app_birthday_create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $userRepo->find($data['id']); // l'ID de l'utilisateur


        $birthday = new Birthday();

        $birthday->setTitle($data['title']);
        $birthday->setDate(new \DateTimeImmutable($data['date']));
        $birthday->setUser($user); 

        $entityManager->persist($birthday);
        $entityManager->flush();

        return $this->json(['message' => 'Birthday created successfully'], 201);
    }

    /**
     * @Route("/birthday/{id}", name="app_birthday_read", methods={"GET"})
     */
    public function read(Birthday $birthday): JsonResponse
    {
        
        return $this->json($birthday);
    }

    /**
     * @Route("/birthday/{id}", name="app_birthday_update", methods={"PUT"})
     */
    public function update(Request $request, Birthday $birthday, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $birthday->setTitle($data['title'] ?? $birthday->getTitle());
        $birthday->setDate(new \DateTimeImmutable($data['date'] ?? $birthday->getDate()->format('Y-m-d')));

        $entityManager->flush();

        return $this->json(['message' => 'Birthday updated successfully']);
    }

    /**
     * @Route("/birthday/{id}", name="app_birthday_delete", methods={"DELETE"})
     */
    public function delete(Birthday $birthday, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($birthday);
        $entityManager->flush();

        return $this->json(['message' => 'Birthday deleted successfully']);
    }
}