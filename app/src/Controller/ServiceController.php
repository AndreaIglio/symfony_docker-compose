<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\AbstractType;

class ServiceController extends AbstractController
{

    /**
     *@Route("/service", name="service.index")
     * add ServiceRepository to be able to query from db
     */
    public function index(Request $request, ServiceRepository $serviceRepository){

        $services = $serviceRepository->findAll();

        return $this->render('service/index.html.twig',[
            'services' => $services,
        ]);
    }



    /**
     * @Route("/service/create", name="service.create")
     * added EntityManager to be able to persist data to the database
     */
//    #[Route('/service', name: 'service')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        /**
         * @var Service $service
         * creiamo variabile $service che crea un nuovo oggetto dell'entity Service
         */
        $service = new Service();

        /**
         * @var FormInterface $serviceForm
         */
        $serviceForm = $this->createForm(ServiceType::class, $service);
        $serviceForm->handleRequest($request);

        if($serviceForm->isSubmitted() && $serviceForm->isValid()){
            $service = $serviceForm->getData();
            /**
             * persist() per salvare in modo temporaneo quello che verra' salvato a db
             */
            $entityManager->persist($service);
            /**
             * flush() salva realmente il dato ($service) a db
             */
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Your AWS service was added!',
            );

        }

        return $this->render('service/create.html.twig', [
            'controller_name' => 'ServiceController',
            'form'=> $serviceForm->createView(),
        ]);
    }

    /**
     *@Route("/service/delete/{id}", name="service.delete")
     */
    public function delete(Service $service, EntityManagerInterface $entityManager){

        $entityManager->remove($service);
        $entityManager->flush();

        $this->addFlash('success', 'The service has been removed successfully');

        return $this->redirect($this->generateUrl("service.index"));

    }
    /**
     *@Route("/service/show/{id}", name="service.show")
     */
    public function show(Service $service){

//        dump($service);
        return $this->render('service/show.html.twig',[
            'service' => $service,
        ]);

    }
    /**
     *@Route("/service/edit/{id}", name="service.edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, ServiceRepository $serviceRepository, Service $service){

        /**
         * @var FormInterface $serviceForm
         */
        $serviceForm = $this->createForm(ServiceType::class, $service);
        $serviceForm->handleRequest($request);

        if($serviceForm->isSubmitted() && $serviceForm->isValid()){
            $service = $serviceForm->getData();
            /**
             * persist() per salvare in modo temporaneo quello che verra' salvato a db
             */
            $entityManager->persist($service);
            /**
             * flush() salva realmente il dato ($service) a db
             */
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Your AWS service was edited!',
            );

            return $this->redirectToRoute('service.index');

        }

        return $this->render('service/edit.html.twig', [
            'form'=> $serviceForm->createView(),
        ]);


    }
}
