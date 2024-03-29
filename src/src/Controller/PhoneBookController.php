<?php

namespace App\Controller;

use App\Entity\PhoneBook;
use App\Entity\User;
use App\Form\PhoneBookType;
use App\Repository\PhoneBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * @Route("/phonebook")
 */
class PhoneBookController extends AbstractController
{
    /**
     * @Route("/", name="phone_book_index", methods={"GET"})
     */
    public function index(PhoneBookRepository $phoneBookRepository): Response
    {
        $user = $this->getUser();

        return $this->render('phone_book/index.html.twig', [
            'phone_books' => $user->getPhoneBook(),
        ]);
    }

    /**
     * @Route("/new", name="phone_book_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $phoneBook = new PhoneBook();
        $form = $this->createForm(PhoneBookType::class, $phoneBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $phoneBook->addUser($this->getUser());
            $entityManager->persist($phoneBook);
            $entityManager->flush();

            return $this->redirectToRoute('phone_book_index');
        }

        return $this->render('phone_book/new.html.twig', [
            'phone_book' => $phoneBook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="phone_book_show", methods={"GET"})
     */
    public function show(PhoneBook $phoneBook): Response
    {
        return $this->render('phone_book/show.html.twig', [
            'users' => $phoneBook->getUsers(),
            'phone_book' => $phoneBook,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="phone_book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PhoneBook $phoneBook): Response
    {
        $this->denyAccessUnlessGranted('CAN_EDIT', $phoneBook);

        $form = $this->createForm(PhoneBookType::class, $phoneBook);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phone_book_index');
        }

        return $this->render('phone_book/edit.html.twig', [
            'phone_book' => $phoneBook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="phone_book_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PhoneBook $phoneBook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phoneBook->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($phoneBook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('phone_book_index');
    }
}
