<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register', methods: ['POST'])]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validate the received data
        if (!$data || !isset($data['email'], $data['password'], $data['role'])) {
            return new JsonResponse(['status' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Create new user and set properties
        $user = new User();
        $user->setEmail($data['email']);
        $user->setRole($data['role']);

        // Validate user entity
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['status' => 'Validation failed', 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Hash the password and set it
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        try {
            // Persist and flush the user entity
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse(['status' => 'User created!'], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            // Handle potential errors
            return new JsonResponse(['status' => 'User creation failed', 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/users/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function getUserById(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['status' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($user);
    }

    #[Route('/users', name: 'get_users', methods: ['GET'])]
    public function getUsers(EntityManagerInterface $entityManager): JsonResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->json($users);
    }

    #[Route('/users/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(
        int $id, 
        Request $request, 
        EntityManagerInterface $entityManager, 
        ValidatorInterface $validator, 
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['status' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['password'])) {
            $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
        }
        if (isset($data['role'])) {
            $user->setRole($data['role']);
        }

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['status' => 'Validation failed', 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $entityManager->flush();

            return new JsonResponse(['status' => 'User updated!'], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'User update failed', 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/users/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['status' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $entityManager->remove($user);
            $entityManager->flush();

            return new JsonResponse(['status' => 'User deleted!'], JsonResponse::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'User deletion failed', 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/login', name: 'user_login', methods: ['POST'])]
    public function login(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['email'], $data['password'])) {
            return new JsonResponse(['status' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(['status' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['status' => 'Login successful', 'user' => $user->getEmail()]);
    }
}
