<?php
namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use App\Entity\Customers;
use App\Entity\VisitTimes;
use App\Entity\Staff;
use App\Form\Type\CustomerType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;


class CustomerController extends AbstractController
{

    protected $customersShowLimit = 5;
    protected $customerId = null;
    protected $customerRegistered = false;

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {

        $message = '';

        if ($request->get('message')) {
            $message = $request->get('message');
        } 


        return $this->render('index.html.twig', [
            'message' => $message
        ]);
    } 


   /**
     * @Route("/board", name="board_view")
     */
    public function showBoard(Request $request)
    {


        if ($request->get('limit')) {
            $this->customersShowLimit = $request->get('limit');
        } 

        if ($request->get('customerRegistered')) {
            $this->customerRegistered = $request->get('customerRegistered');
        } 


        $customers = $this->getCustomersNotServed($this->customersShowLimit);

        return $this->render('board.html.twig', [
            'customers' => $customers,
            'customerRegistered' => $this->customerRegistered
        ]);

    }    

    /**
     * @Route("/customer", name="customer_view")
     */
    public function showCustomer(Request $request)
    {

        if ($request->get('customerId')) {
            $this->customerId = $request->get('customerId');

            return $this->render('customer/customer_view.html.twig', [
                'customerId' => $this->customerId
            ]);
        }


        return $this->redirectToRoute('board_view');

    }

    /**
     * @Route("/customer/new", name="customer_form")
     */
    public function customerForm(Request $request)
    {

        $customer = new Customers();


        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->customerRegistered = true;

            $customer = $form->getData();

            $this->addCustomerToDb($customer);
            $this->customerVisitTimeDb($customer, $customer->getStaff()); 

            return $this->redirectToRoute(
                'board_view', 
                ['customerRegistered' => $this->customerRegistered]
            );

        }


        return $this->render('customer/customer_form.html.twig', [
            'form' => $form->createView(),
        ]);            

    }


    /**
     * Ads new customer to database
     *
     * @param object $customer
     *
     */    
    public function addCustomerToDb($customer)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($customer);
        $entityManager->flush();
        
    }    

    /**
     * Ads/Updates customers visit times
     *
     * @param object $customer
     * @param object $staff
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @param int $duration
     *
     */    
    public function customerVisitTimeDb($customer, $staff = NULL, DateTime $startTime = NULL, DateTime $endTime = NULL, int $duration = NULL)
    {

        $time = new VisitTimes();

        if ($customer) {
            $time->setCustomer($customer);
        }

        if ($staff) {
            $time->setStaff($staff);
        }

        if ($startTime) {
            $time->setVisitStartTime($startTime);
        } else {
            $time->setVisitStartTime(NULL);
        }

        if ($endTime) {
            $time->setVisitEndTime($endTime);
        } else {
            $time->setVisitEndTime(NULL);
        }

        if ($duration) {
            $time->setVisitDuration($duration);
        } else {
            $time->setVisitDuration(NULL);
        }


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($time);
        $entityManager->flush();
        
    } 

    /**
     * Counts duration of visit
     *
     * @param int $visitId
     * @param int $staffId
     * @param int $customerId
     *
     * @return int minutes.
     */    
    public function countDurationOfVisit(int $visitId = 0, int $staffId = 0, int $customerId = 0)
    {


        $criteria = [];

        if ($visitId > 0) {
            $criteria = ['id' => $visitId];
        } elseif ($staffId > 0) {
           $criteria = [
            'staff' => $staffId,
            'visitDuration' => NULL,
        ];
        } elseif ($customerId > 0) {
           $criteria = [
            'customer' => $customerId,
            'visitDuration' => NULL,
        ];
        } else {
            return 0;
        }

        $repository = $this->getDoctrine()->getRepository(VisitTimes::class);

        $visit = $repository->findOneBy(
            $criteria  
        );

        if (!$visit) {
            throw $this->createNotFoundException(
                'Visit time was not found'
            );
        }        

        $startTime = $visit->getVisitStartTime();


        if ($visit->getVisitEndTime()) {
            $endTime = $visit->getVisitEndTime();
        } else {
            $endTime = new \DateTime();
        }

        $diff = $startTime->diff($endTime);

        $minutes = $diff->h * 60;   
        $minutes += $diff->i;  

        return $minutes;        
    } 


    /**
     * Finds not served customers
     *
     * @param int|null   $limit
     *
     * @return array The objects.
     */    
    public function getCustomersNotServed($limit = null)
    {
        $repository = $this->getDoctrine()->getRepository(Customers::class);

        $customers = $repository->findBy(
            ['served' => 0], // criteria
            ['id' => 'ASC'], // orderBy
            $limit,          // limit
        );

        return $customers;
        
    }     

    /**
     * Finds all customers
     *
     * @param int|null   $limit
     *
     * @return array The objects.
     */    
    public function getCustomersAll($limit = null)
    {
        $repository = $this->getDoctrine()->getRepository(Customers::class);

        if ($limit) {
            $limit = ($limit == 'all' ? null : $limit);
        }

        $customers = $repository->findBy(
            [],              // criteria
            ['id' => 'ASC'], // orderBy
            $limit           // limit
        );

        return $customers;        
    }   


}