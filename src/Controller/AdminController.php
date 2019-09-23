<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Customers;
use App\Entity\Staff;
use App\Form\Type\AdminType;


class AdminController extends CustomerController 
{



    /**
     * @Route("/admin", name="admin_customer_show")
     */
    public function adminCustomer(Request $request, $id = 0)
    {

        if ($request->get('limit')) {
            $this->customersShowLimit = $request->get('limit');
        } 

        if ($request->get('servedCustomerId')) {
            $this->customerId = $request->get('servedCustomerId');
        } 

        $customers = $this->getCustomersAll($this->customersShowLimit);

        return $this->render('admin/administration.html.twig', [
            'customers' => $customers,
            'servedCustomerId' => $this->customerId,
        ]);

    }


    /**
     * @Route("/admin/customerServed/{id}", name="admin_customer_served", requirements={"id"="\d+"})
     */
    public function customerServed($id, Request $request)
    {

        $served = 1;
        $durationMinutes = 0;

        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Customers::class)->find($id);

        if (!$customer) {
            throw $this->createNotFoundException(
                'No customer found by id '. $id
            );
        }

        $durationMinutes = $this->countDurationOfVisit(0, 0, $customer->getId());   // Count duration
        $this->customerVisitTimeDb($customer, NULL, NULL, NULL, $durationMinutes);  // Update DB by adding duration


        $customer->setServed($served);
        $entityManager->flush();

        return $this->redirectToRoute('admin_customer_show', [
            'servedCustomerId' => $customer->getId(),
            'limit' => $request->get('limit')
        ]);
    }

    /**
     * @Route("/admin/customerDelete/{id}", name="admin_customer_delete", requirements={"id"="\d+"})
     */
    public function customerDelete($id, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Customers::class)->find($id);

        if (!$customer) {
            throw $this->createNotFoundException(
                'No customer found by id '.$id
            );
        }

        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->redirectToRoute('admin_customer_show', [
            'servedCustomerId' => $customer->getId(),
            'limit' => $request->get('limit')
        ]);
    }

}