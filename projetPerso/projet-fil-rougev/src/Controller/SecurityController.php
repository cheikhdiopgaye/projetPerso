<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ComptBType;
use App\Entity\Partenaires;
use App\Entity\CompteBancaire;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartenairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

/**
 * @Route("/api")
 */
class SecurityController extends FOSRestController
{
    /**
     * @Route("/AjoutCaissier", name="super", methods={"POST"})
     */
    public function admin(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $data = $request->request->all();
        $file = $request->files->all()['imageFile'];
        $form->submit($data);
        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );
        $user->setProfil('caissier');
        $user->setRoles(["ROLE_CAISSIER"]);
        $user->setImageFile($file);
        $user->setUpdatedAt(new \DateTime());
        $user->setEtat('actif');
       
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

                return $this->handleView($this->view(['statut' => 'ok'], Response::HTTP_CREATED));
        }
            return $this->handleView($this->view($form->getErrors()));
    }
    /**
     * @Route("/adduser", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, PartenairesRepository $partenaire, EntityManagerInterface $entityManager)
    {
       
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $data = $request->request->all();
        $file = $request->files->all()['imageFile'];
        $form->submit($data);
        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );
        $user->setProfil($data['profil']);
        $profil=$user->getProfil();
        $roles=[];

        if($profil =="admin"){
            $roles=["ROLE_ADMIN"];
        }
        elseif($profil == "user"){
            $roles=["ROLE_UTILISATEUR"];
        }
        $user->setRoles($roles);
        $user->setImageFile($file);
        $user->setUpdatedAt(new \DateTime());
        $user->setEtat('actif');
        $uers= $this->getUser();
        $partd=$uers->getIdPartenaire()->getId();
        $part=$partenaire->find($partd);
        $user->setIdPartenaire($part);
        $repo = $this->getDoctrine()->getRepository(CompteBancaire::class);
        $compte = $repo->findOneBy( ['numeroCompte'=> $data['numeroCompte']]);
        $user->setCompteuser($compte);
        

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

                return $this->handleView($this->view(['statut' => 'L\'utlisateur est enregistré avec succés'], Response::HTTP_CREATED));
        }
            return $this->handleView($this->view($form->getErrors()));
    }


    /**
     * @Route("/logincheck", name="login", methods={"POST","GET"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }    
}