<?php

namespace App\Controller\Admin;

use App\Entity\Clients;
use App\Entity\SalesOrder;
use App\Entity\SalesOrderItem;
use App\Entity\SalesOrderMapping;
use App\Repository\SalesOrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sales-order")
 */
class SalesOrderController extends AbstractController
{
    /**
     * @Route("/", name="sales_order_index", methods={"GET"})
     */
    public function index(SalesOrderRepository $salesOrderRepository): Response
    {
        return $this->render('admin/sales_order/index.html.twig', [
            'sales_orders' => $salesOrderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $items = $entityManager->getRepository(SalesOrderItem::class)->getSalesOrderItems();
        if($request->getMethod() == Request::METHOD_POST)
        {
            $isValid = $this->validateSubmittedData($request, $entityManager);
            if($isValid['status'])
            {
                return $this->redirectToRoute('sales_order_show', ['id' => $isValid['data']->getId()]);
            }
            else
            {
                $this->addFlash('error', $isValid['message']);
            }
        }
        return $this->render('admin/sales_order/new.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @Route("/{id}", name="sales_order_show", methods={"GET"})
     */
    public function show(SalesOrder $salesOrder): Response
    {
        return $this->render('admin/sales_order/show.html.twig', [
            'salesOrder' => $salesOrder,
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return array
     */
    private function validateSubmittedData(Request $request, EntityManagerInterface $entityManager)
    {
        $result = ['status' => false, 'message' => ""];
        $requestData = $request->request->all();
        try
        {
            if(($requestData['clientName'] ?? null) && ($requestData['clientAddress'] ?? null) && ($requestData['orderItems'] ?? null) && ($requestData['totalPrice'] ?? null))
            {
                $user = $this->getUser();
                $client = new Clients();
                $client->setName($requestData['clientName'])->setLocation($requestData['clientAddress']);
                $entityManager->persist($client);
                $salesOrder = new SalesOrder();
                $salesOrder->setAdmin($user)
                    ->setClient($client)
                    ->setSalesOrderNo(sprintf("SO-%s", time()))
                    ->setTotalValue($requestData['totalPrice']);
                $entityManager->persist($salesOrder);
                $entityManager->flush();
                foreach ($requestData['orderItems'] as $orderItem)
                {
                    $item = $entityManager->getReference(SalesOrderItem::class, $orderItem);
                    $mapping = new SalesOrderMapping();
                    $mapping->setSalesOrder($salesOrder);
                    $mapping->setSalesOrderItem($item);
                    $entityManager->persist($mapping);
                }
                $entityManager->flush();
                $result['status'] = true;
                $result['data'] = $salesOrder;
            }
            else
            {
                $result['message'] = "Invalid Request: Some fields are missing";
            }
        }
        catch (\Exception $exception)
        {
            $result['message'] = sprintf("Server Error: %s", $exception->getMessage());
        }
        return $result;
    }
}
