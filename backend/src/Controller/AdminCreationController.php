<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\AdminCreationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AdminCreationController extends AbstractController
{
    private string $adminRole;

    public function __construct(ParameterBagInterface $params) {
        $this->adminRole = $params->get('admin_role');
    }

    #[Route('/create-admin', name: 'app_create_admin')]
    public function createAdmin(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $existingAdmin = $entityManager->getRepository(User::class)->findOneBy(['role' => $this->adminRole]);

        if ($existingAdmin) {
            $this->addFlash('error', 'Un admin existe deja. Vous allez être redirigé.');
            return $this->redirectToRoute('home_page');
        }

        $user = new User();
        $user->setRole($this->adminRole);

        $form = $this->createForm(AdminCreationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);


            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Admin crée avec succées!');
            return $this->redirectToRoute('home_page');
        }

        return $this->render('admin/create_admin.html.twig', [
            'adminCreationForm' => $form->createView(),
            'existingAdmin' => $existingAdmin !== null,
        ]);
    }
}