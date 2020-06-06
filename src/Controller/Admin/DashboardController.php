<?php


namespace App\Controller\Admin;


use App\Entity\SalesOrder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

/**
 * Class DashboardController
 * @package App\Admin\Controller
 * @Route("/", name="admin_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function dashboard()
    {
        $em = $this->getDoctrine()->getManager();
        $currentYearSales = $em->getRepository(SalesOrder::class)->getCurrentYearSales();
        $years = ["2015", "2016", "2017", "2018", "2019", "2020"];
        $yearlySales = $em->getRepository(SalesOrder::class)->getYearlySales();
        rsort($years);
        return $this->render('admin/dashboard/dashboard.html.twig', ['salesData' => $currentYearSales, 'currentYearSales' => array_values($currentYearSales['sales']), 'years' => $years, 'yearlySales' => ['years' => array_keys($yearlySales['sales']), 'sales' => array_values($yearlySales['sales'])]]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/salesData", name="dashboard_sales_data_api")
     */
    public function getSalesData(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $salesData = $em->getRepository(SalesOrder::class)->getCurrentYearSales($request->query->get('year', null));
        $salesData['sales'] = array_values($salesData['sales']);
        $salesData['success'] = true;
        return new JsonResponse($salesData);
    }
}