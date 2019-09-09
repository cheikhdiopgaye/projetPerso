<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Form\UserType;
use App\Form\DepotType;
use App\Form\ComptBType;
use App\Entity\Partenaires;
use App\Form\PartenaireType;
use App\Entity\CompteBancaire;
use App\Repository\UserRepository;

use App\Repository\DepotRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PartenairesRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

/**
 * @Route("/api")
 */
class WariController extends FOSRestController
{
    
    /**
     * @Rest\Get("/partenaires", name="find_partenaires")
     */
    public function index(PartenairesRepository $partRepository, SerializerInterface $serializer)

    {
        
        $partenaire  = $partRepository->findAll();
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($partenaire, 'json', [
        'circular_reference_handler' => function ($object) {
        return $object->getId();
    }
        ]);

        // For instance, return a Response with encoded Json
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
    //listes de utilisateurs
     /**
     * @Rest\Get("/list", name="find_users")
     */
    public function user(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $partenaire  = $userRepository->findAll();
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($partenaire, 'json', [
        'circular_reference_handler' => function ($object) {
        return $object->getId();
    }
]);

// For instance, return a Response with encoded Json
return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
     /**
     * @Rest\Get("/userview", name="find_users")
     */
    public function viewUser(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        // Serialize your object in Json
        $jsonObject = $serializer->serialize($partenaire, 'json', [
        'circular_reference_handler' => function ($object) {
        return $object->getId();
    }
]);

// For instance, return a Response with encoded Json
return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
//liste des depots
    /**
     * @Rest\Get("/depots", name="find_depot")
     */
    public function listeDepot(DepotRepository $depotRepository, SerializerInterface $serializer)
    {
        $partenaire  = $depotRepository->findAll();
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($partenaire, 'json', [
        'circular_reference_handler' => function ($object) {
        return $object->getId();
    }
        ]);

        // For instance, return a Response with encoded Json
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
       
    }
     
//Rechercher un partenaire
    /**
     * @Route("/partenaire/{raisonSocial}", name="show_parteenaire", methods={"GET"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function show(Partenaires $partenaire, PartenairesRepository $partenairesRepository, SerializerInterface $serializer)
    {
        $partenaire = $partenairesRepository->find($partenaire->getRaisonSocial());
        $data = $serializer->serialize($partenaire, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
    /**
     * @Route("/ajout/{id}", name="bloquer", methods={"PUT"})
     *  @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function bloquerPartenaie(Request $request, SerializerInterface $serializer, Partenaires $partenaire, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $bloqueP = $entityManager->getRepository(Partenaires::class)->find($partenaire->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value) {
            if ($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $bloqueP->$setter($value);
            }
        }
        $errors = $validator->validate($bloqueP);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');

            return new Response($errors, 500, [
                'Content-Type' => 'application/json',
            ]);
        }
        $entityManager->flush();
        $data = [
            'statuss' => 200,
            'messages' => 'L \'etat du partenaire a bien été mis à jour',
        ];

        return new JsonResponse($data);
    }
//Ajouter un compte à un partenaire
    /**
     * @Route("/AjoutCompte", name="compt", methods={"POST"})
     */
    public function ajoutComptB(Request $request, EntityManagerInterface $entityManager, PartenairesRepository $partenaire)
    {
      
        $comptes = date('d').date('m').date('y').date('H').date('i').date('s');
        $compb = new CompteBancaire();
        $form = $this->createform(ComptBType::class, $compb);
        $form->handleRequest($request);
        $data = $request->request->all();
        $form->submit($data);
        $compb->setNumeroCompte($comptes);
        $compb->setSolde(0);
        $part=$partenaire->findOneBy([ 'raisonSocial'=>$data['raisonSocial']]);
        $compb->setPartenaire($part);
        //enregistrement au niveau du depot
        $entityManager->persist($compb);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => 'Le compte bancaire  a été bien créer ',
        ];

        return new JsonResponse($data, 201);
    }

    //Effectuer un dépôt sur un compte d'un
    /**
     * @Route("/depot", name="depot", methods={"POST"})
     */
    public function depot(Request $request, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
       
            $depot = new Depot();
            $form = $this->createform(DepotType::class, $depot);
            $form->handleRequest($request);
            $data = $request->request->all();
            $form->submit($data);
            $depot->setDateDepot(new \DateTime());
            $repo = $this->getDoctrine()->getRepository(CompteBancaire::class);
            $partenaire = $repo->findOneBy([ 'numeroCompte'=>$data['numeroCompte']]);
            $depot->setComptb($partenaire);
            $partenaire->setSolde($partenaire->getSolde() + $depot->getMontant());
            if ( $depot->getMontant() > 75000) {
                $entityManager->persist($partenaire);

                $entityManager->persist($depot);
                $entityManager->flush();

                $data = [
                    'status' => 201,
                    'message' => 'Dépot effectué avec succcés',
                ];

                return new JsonResponse($data, 201);
            }
                $data = [
                    'status' => 500,
                    'message' => 'Vous devez saisir un montant supérieur',
                ];

                return new JsonResponse($data, 500);
    }

    /**
     * @Route("/Entreprise", name="app_register", methods={"POST"})
     */
    public function addPartenaire(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $comptes = date('d').date('m').date('y').date('H').date('i').date('s');
        $partenaire = new Partenaires();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        $data = $request->request->all();
        $form->submit($data);
        $partenaire->setEtats('Debloquer');

        $compte = new CompteBancaire();
        $compte->setNumeroCompte($comptes);
        $compte->setSolde(0);
        // relates this product to the category
        $compte->setPartenaire($partenaire);

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
        $user->setRoles(['ROLE_ADMIN_PART']);
        $user->setImageFile($file);
        $user->setUpdatedAt(new \DateTime());
        $user->setEtat('Debloquer');
        $user->setProfil('admin');
        $user->setIdPartenaire($partenaire);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
            $entityManager->persist($compte);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}