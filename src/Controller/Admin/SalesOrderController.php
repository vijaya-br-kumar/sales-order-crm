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
     * @param SalesOrder|null $oldSalesOrder
     * @return array
     */
    private function validateSubmittedData(Request $request, EntityManagerInterface $entityManager, SalesOrder $oldSalesOrder = null)
    {
        $result = ['status' => false, 'message' => ""];
        $requestData = $request->request->all();
        try
        {
            if(($requestData['clientName'] ?? null) && ($requestData['clientAddress'] ?? null) && ($requestData['orderItems'] ?? null) && ($requestData['totalPrice'] ?? null))
            {
                $user = $this->getUser();
                $client = ($oldSalesOrder instanceof SalesOrder) ? $oldSalesOrder->getClient() : new Clients();
                $client->setName($requestData['clientName'])->setLocation($requestData['clientAddress']);
                $entityManager->persist($client);
                $salesOrder = ($oldSalesOrder instanceof SalesOrder) ? $oldSalesOrder : new SalesOrder();
                $salesOrder->setAdmin($user)
                    ->setClient($client)
                    ->setTotalValue($requestData['totalPrice']);
                if(is_null($oldSalesOrder))
                {
                    $salesOrder->setSalesOrderNo(sprintf("SO-%s", time()));
                }
                if($oldSalesOrder instanceof SalesOrder)
                {
                    foreach ($oldSalesOrder->getSalesOrderMappings() as $orderMapping)
                    {
                        $oldSalesOrder->removeSalesOrderMapping($orderMapping);
                    }
                }
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


    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @Route("/{id}/edit", name="sales_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entity = $entityManager->getRepository(SalesOrder::class)->findOneBy(['id' => $id]);
        if($entity instanceof SalesOrder)
        {
            $items = $entityManager->getRepository(SalesOrderItem::class)->getSalesOrderItems();
            if($request->getMethod() == Request::METHOD_POST)
            {
                $isValid = $this->validateSubmittedData($request, $entityManager, $entity);
                if($isValid['status'])
                {
                    return $this->redirectToRoute('sales_order_show', ['id' => $isValid['data']->getId()]);
                }
                else
                {
                    $this->addFlash('error', $isValid['message']);
                }
            }
            return $this->render('admin/sales_order/edit.html.twig', [
                'items' => $items, 'entity' => $entity
            ]);
        }
        $this->addFlash('error', sprintf('Sales Order not found with Id: %s', $id));
        return $this->redirectToRoute('sales_order_index');
    }

    /**
     * @param Request $request
     * @param SalesOrder $salesOrder
     * @return Response
     * @Route("/{id}", name="sales_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SalesOrder $salesOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salesOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salesOrder);
            $entityManager->flush();
            $this->addFlash('success', "Successfully Removed the item");
        }

        return $this->redirectToRoute('sales_order_index');
    }
}
