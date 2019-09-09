<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Depot;

use App\Form\BenfType;
use App\Entity\Envoyer;

use App\Entity\Retrait;
use App\Form\EnvoieType;
use App\Form\RetraitType;
use App\Entity\Transaction;
use App\Entity\Beneficiaire;
use App\Form\TransactionType;
use App\Entity\CompteBancaire;
use JMS\Serializer\SerializerBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
/**
 * @Route("/api")
 */
class TransactionController extends FOSRestController
{
    /**
     * @Route("/transaction", name="transaction")
     */
    public function index()
    {
              // Configure Dompdf according to your needs
              $pdfOptions = new Options();
              $pdfOptions->set('defaultFont', 'Arial');
      
              // Instantiate Dompdf with our options
              $dompdf = new Dompdf($pdfOptions);
      
              // Retrieve the HTML generated in our twig file
              $html = $this->renderView('transaction/mypdf.html.twig', [
                  'title' => 'Welcome to our PDF Test',
              ]);
      
              // Load HTML to Dompdf
              $dompdf->loadHtml($html);
      
              // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
              $dompdf->setPaper('A4', 'portrait');
      
              // Render the HTML as PDF
              $dompdf->render();
      
              // Output the generated PDF to Browser (inline view)
              $dompdf->stream('mypdf.pdf', [
                  'Attachment' => false,
              ]);
          }
      
          //liste des depots
      
          /**
           * @Rest\Get("/depots", name="find_depot")
           */
          public function listeDepot()
          {
              $repo = $this->getDoctrine()->getRepository(Depot::class);
              $depot = $repo->findAll();
      
              return $this->handleView($this->view($depot));
          }
      
         
          //Effectuer un envoie
      
          /**
           * @Route("/envoie", name="envoie", methods={"POST"})
           */
          public function transfert(Request $request, EntityManagerInterface $entityManager): Response
          {
              //Ajout des informations de l'envoyeur
              $envoyeur = new Envoyer();
              $form = $this->createForm(EnvoieType::class, $envoyeur);
              $form->handleRequest($request);
              $data = $request->request->all();
              $form->submit($data);
      
               //Ajout des informations du bénéficiaire
              $beneficiaire = new Beneficiaire();
              $form = $this->createForm(BenfType::class, $beneficiaire);
              $form->handleRequest($request);
              $data = $request->request->all();
              $form->submit($data);
      
              //Ajout des informations de l'envoie
              $envoie = new Transaction;
              $code= random_int(100000000,999999999);
              $num= random_int(100000000,999999999);
              
              $form = $this->createForm(TransactionType::class, $envoie);
              $form->handleRequest($request);
              $data = $request->request->all();
              $form->submit($data);
              
              $envoie->setEnvoyeur($envoyeur);
              $envoie->setBenef($beneficiaire);
              $envoie->setCodedenvoie($code);
              $envoie->setDatedenvoie(new \DateTime('now'));
              $envoie->setDelairetrait($envoie->getDateDenvoie());
              $ch=$this->getUser();
              $numreocompte=$ch->getCompteuser()->getId();
            
              $envoie->setNumerotrans($num);
              
              $repo = $this->getDoctrine()->getRepository(CompteBancaire::class);
              $compte = $repo->find( $numreocompte/* ['numeroCompte'=> $data['numeroCompte']] */);
              $envoie->setCompte($compte);
              $compte->setSolde($compte->getSolde() - $envoie->getMontanttrans()); 
              
             
              if ($form->isSubmitted()) {
                  
                  $entityManager = $this->getDoctrine()->getManager();
                  $entityManager->persist($compte);
                  $entityManager->persist($envoyeur);
                  $entityManager->persist($beneficiaire);
                  $entityManager->persist($envoie);
                  $entityManager->flush();

                  return $this->handleView($this->view(['status' => 'Envoie effectué avec successé'], Response::HTTP_CREATED));
                
              }
      
              return $this->handleView($this->view($form->getErrors()));
          }
      
          //liste des transactions
      
          /**
           * @Rest\Get("/trans", name="find_transactions")
           */
          public function listeTransactions()
          {
              $repo = $this->getDoctrine()->getRepository(Transactions::class);
              $trans = $repo->findAll();
      
              return $this->handleView($this->view($trans));
          }
      
          // retrait
      
          /**
           * @Route("/Retrait", name="Retrait", methods={"POST"})
           */
          public function retrait()
          {
            
              $retrait= new Retrait();
              $form = $this->createForm(RetraitType::class, $retrait);
              $form->handleRequest($request);
              $data = $request->request->all();
              $form->submit($data);
              $retrait->setDatedenvoie(new \DateTime('now'));
              $repo = $this->getDoctrine()->getRepository(Transaction::class);
              $envoie = $repo->findOneBy([ 'codedenvoie'=> $data['codedenvoie']]);
              $retrait->setEnvoie($envoie);
              $ch=$this->getUser();
              $numreocompte=$ch->getCompteuser()->getId();
               var_dump($numreocompte); 
              var_dump($ch); die();
              $repo = $this->getDoctrine()->getRepository(CompteBancaire::class);
              $compte = $repo->find($numreocompte);
              $info= $compte->getSolde();
              $envoie->setCompte($compte);
              $compte->setSolde($compte->getSolde() + $envoie->getMontanttrans());
              if ($form->isSubmitted()) {
                if ( $info >= $envoie->getMontanttrans()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($compte);
                $entityManager->persist($retrait);
                $entityManager->flush();
                return $this->handleView($this->view(['status' => 'Envoie effectué avec successé'], Response::HTTP_CREATED));
                } 
                else {
                                              
                  return $this->handleView($this->view(['status' => 'Votre solde ne vous permet pas deffectuer cet transfert'], Response::HTTP_CREATED));
                }
            }
            return $this->handleView($this->view($form->getErrors()));
          }
    

}
