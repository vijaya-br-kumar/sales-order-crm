<?php
namespace App\Services;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    /**
     * @var EntityManagerInterface 
     */
    private $entityManager;
    /**
     * @var FlickrService
     */
    private $flickrService;

    public function __construct(EntityManagerInterface $entityManager, FlickrService $flickrService)
    {
        $this->entityManager = $entityManager;
        $this->flickrService = $flickrService;
    }

    /**
     * @return array
     */
    public function getCategoryList()
    {
        $response = ['success' => false, 'message' => ""];
        try
        {
            $categoryList = $this->entityManager->getRepository(Category::class)->getCategoryList();
            if($categoryList['status'])
            {
                $response['success'] = true;
                $response['data'] = $categoryList['data'];
            }
            else
            {
                $response['message'] = $categoryList['message'];
            }
        }
        catch (\Exception $exception)
        {
            $response['message'] = sprintf("Server Error: (%s)", $exception->getMessage());
        }
        return $response;
    }

    /**
     * @param string $category
     * @return array
     */
    public function getCategoryData(string $category)
    {
        #https://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg
        $response = ['success' => false, 'message' => ""];
        try
        {
            $apiResponse = $this->flickrService->getImagesByCategory($category);
            if($apiResponse['status'])
            {
                foreach ($apiResponse['data']['photos']['photo'] as $photo)
                {
                    $farm = (($photo['farm'] == 0) ? 66 : $photo['farm']);
                    $response['data'][] = [
                        "id" => $photo['id'],
                        "secret" => $photo['secret'],
                        "server" => $photo['server'],
                        "farm" => $farm,
                        "path" => sprintf("https://farm%s.staticflickr.com/%s/%s_%s.jpg", $farm, $photo['server'], $photo['id'], $photo['secret'])
                    ];
                }
                $response['success'] = true;
            }
            else
            {
                $response['message'] = $apiResponse['message'];
            }
        }
        catch (\Exception $exception)
        {
            $response['message'] = sprintf("Server Error: (%s)", $exception->getMessage());
        }
        return $response;
    }

    /**
     * @param string $imageId
     * @return array
     */
    public function getImageDescription($imageId)
    {
        $response = ['success' => false, 'message' => ""];
        try
        {
            $apiResponse = $this->flickrService->getImagesDescription($imageId);
            if($apiResponse['status'])
            {
                $photo = $apiResponse['data']['photo'];
                $farm = (($photo['farm'] == 0) ? 66 : $photo['farm']);
                $response['data'] = [
                    "id" => $photo['id'],
                    "secret" => $photo['secret'],
                    "server" => $photo['server'],
                    "farm" => $farm,
                    "path" => sprintf("https://farm%s.staticflickr.com/%s/%s_%s.jpg", $farm, $photo['server'], $photo['id'], $photo['secret']),
                    "description" => $photo['description']['_content'] ?? "No Content Available"
                ];
                $response['success'] = true;
            }
            else
            {
                $response['message'] = $apiResponse['message'];
            }
        }
        catch (\Exception $exception)
        {
            $response['message'] = sprintf("Server Error: (%s)", $exception->getMessage());
        }
        return $response;
    }
}