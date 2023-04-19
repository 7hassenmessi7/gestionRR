<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Response;
use App\Form\ResponseType;
use App\Repository\ResponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Routing\Annotation\Route;

class ResponseController extends AbstractController
{
    //ajouter

        #[Route('/response/add/{id}', name: 'ajouter.response')]
     
      //@Route("/response/create/{id}", name="response_create")
    
    public function create(Request $request, ManagerRegistry $Doctrine, $id): HttpFoundationResponse
    {
        // Find the reclamation associated with the given ID
        $reclamation = $Doctrine->getRepository(Reclamation::class)->find($id);

        // Create a new Response object
        $response = new Response();

        // Set the associated reclamation for the response
        $response->setReclamation($reclamation);

        // Create a new form for the Response object
        $form = $this->createForm(ResponseType::class, $response);

        // Handle form submission
        $form->handleRequest($request);

        // If the form was submitted and is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the new response to the database
            $entityManager = $Doctrine->getManager();
            $entityManager->persist($response);
            $entityManager->flush();

            // Redirect back to the reclamation details page
            return $this->redirectToRoute('listes.reclamations', ['id' => $id]);
        }

        // Render the form view
        return $this->render('response/add_reponse.html.twig', [
            'form' => $form->createView(),
            'reclamation' => $reclamation,
        ]);
    }

       
        

   
    


    //Affichage 
    #[Route('/response/{idreclamation}', name: 'list.responses')]
public function index(ManagerRegistry $Doctrine, $idreclamation): HttpFoundationResponse
{
    $reclamation = $Doctrine->getRepository(Reclamation::class)->find($idreclamation);
    $response = $Doctrine->getRepository(Response::class)->findOneBy([
        'reclamation' => $reclamation
    ]);

    return $this->render('response/index.html.twig', [
        'reclamation' => $reclamation,
        'response' => $response
    ]);
}
    


}