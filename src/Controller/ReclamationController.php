<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('reclamation')]
class ReclamationController extends AbstractController
{
     //on peut aussi utiliser param converter
    #[Route('/{id<\d+>}',name:'reclamation.detail')]
    public function detailRec(ManagerRegistry $Doctrine, $id):Response{

        $repository=$Doctrine->getRepository(Reclamation::class);
        $reclamation=$repository->find($id);
        echo "hassen";

        if(! $reclamation){
            $this->addFlash(type:'error',message:"this reclamation d'id $id doesn't exist ");
            echo "heyyy";
            return $this->redirectToRoute('list.reclamation');
        }
        return $this->render('reclamation/detail.html.twig',[
            'reclamation'=>$reclamation
        ]);


       }

    
    //Affichage
    #[Route('/',name:'list.reclamations')]
    public function index(ReclamationRepository $repo):Response{
 
    
     $reclamations=$repo->findAll();    


    return $this->render('reclamation/index.html.twig',[
        'reclamations'=>$reclamations

    ]);
    }
    ///find by contact
    #[Route('/condition/{bestcontact}',name:'list.reclamation')]
    public function byconatact(ManagerRegistry $Doctrine,$bestcontact):Response{
 
     $repository =$Doctrine->getRepository(Reclamation::class);
     $reclamations=$repository->bestcontact($bestcontact);    


    return $this->render('reclamation/index.html.twig',[
        'reclamations'=>$reclamations

    ]);
    }

    #[Route('/Alls/{page?1}/{nbre?5}',name:'listes.reclamations')]
     
    public function indesxAlls(ManagerRegistry $Doctrine, $page,$nbre):Response{
        
        //récupérer repo
        $repository=$Doctrine->getRepository(Reclamation::class);
        //pagination
        $nbrReclamations = $repository->count([]); 
      

        $nbrePages =ceil($nbrReclamations/$nbre);
        // dd($nbrePages);
       

        //affichage
  

        $reclamations =$repository->findBy([],[],limit:$nbre,offset:($page-1)*$nbre);
     


        return $this->render('reclamation/index.html.twig',[
            'reclamations'=>$reclamations,
             'isPaginated'=>true,
             'nbrePages'=>$nbrePages,
             'page'=>$page,
             'nbre'=>$nbre
        ]);

    }
    


     //Ajout d'une reclamation
     #[Route('/ajouter/{id?0}', name: 'ajouter.reclamation')]
     public function addReclamation(Reclamation $reclamation=null, ManagerRegistry $Doctrine,Request $request):Response 
     {
        
         $new=false;
        if(!$reclamation){   
         $new=true;
        $reclamation = new Reclamation();
          
        
        }
         $form =$this->createForm(ReclamationType::class,$reclamation);
         $form ->remove('createdAt');
         $form ->remove('user');
 
         $form->handleRequest($request);           
         
         if ($form->isSubmitted() && $form->isValid()){       
             $manager =$Doctrine->getManager();
             $manager->persist($reclamation);
             $manager->flush();
              if($new){
               $message="reclamation a été ajouter avec success";
               } else{
                 $message="reclamation a été modifier avec success";
               }
  
             $this->addFlash(type:'success',message:$message);
         
            
            return $this->redirectToRoute('list.reclamations');
         
    
         } else {
             return $this->render('reclamation/add-form.html.twig',[
                 'form'=>$form]);
           
         }
        
        
    }

    //delete
    #[Route('/delete/{id}',name:'delete.reclamation')]
    public function delete(Reclamation $reclamation=null,ManagerRegistry $Doctrine):RedirectResponse{

        if ($reclamation){
            $entityManager = $Doctrine->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
            $this->addFlash(type:'success',message:"la reclamation a eté supprimé avec success");
           
        }
        else{
            $this->addFlash(type:'error',message:"la reclamation n'existe pas");
            
        }
        return $this->redirectToRoute('listes.reclamations');
    }
     //update
    #[Route('/update/{id}/{contact}/{destinataire}/{type}/{status}/{description}/{response}',name:'updatereclamation')]
    public function update(ManagerRegistry $Doctrine, Reclamation $reclamation=null,$contact,$destinataire,$type,$status,$description){
         
        if($reclamation){
            $reclamation->setContact($contact);
            $reclamation->setDestinataire($destinataire);
            $reclamation->setType($type);
            $reclamation->setStatus($status);
            $reclamation->setDescription($description);
           
     
          $entityManager=$Doctrine->getManager();
          $entityManager->persist($reclamation);
          $entityManager->flush();
          $this->addFlash(type:'success',message:"la reclamation a eté modifie avec success");


        }
        else{
            $this->addFlash(type:'success',message:"la reclamation n'existe pas");


        }
        return $this->redirectToRoute('listes.reclamations');
    }

    }



  





// #Route




  //#[Route('/reclamation', name: 'app_reclamation')]
   // public function index(): Response
    //{
     //   return $this->render('reclamation/index.html.twig', [
           // 'controller_name' => 'ReclamationController',
     //   ]);
  //  }





  //ajoutttttt
    //Ajout d'une reclamation
    /**/
        