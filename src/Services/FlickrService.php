<?php


namespace App\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;

class FlickrService
{
    const METHOD_PHOTOS_SEARCH = "flickr.photos.search";

    const PER_PAGE = 20;
    const STATUS_FAIL = "fail";
    const STATUS_OK = "ok";

    private $apiKey;
    private $apiSecret;
    private $apiUrl;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->apiKey = $parameterBag->get('flickr_api_key');
        $this->apiSecret = $parameterBag->get('flickr_api_secret');
        $this->apiUrl = $parameterBag->get('flickr_api_url');
    }

    public function getImagesByCategory(string $category)
    {
        $result = ['status' => false, 'message' => ""];
        $endpoint = sprintf("%s?method=flickr.photos.search&api_key=%s&text=%s&format=json&nojsoncallback=1&per_page=%s", $this->apiUrl, $this->apiKey, $category, self::PER_PAGE);
        try
        {
            $client = new Client();
            $response = $client->get($endpoint);
            if($response instanceof ResponseInterface && ($response->getStatusCode() == Response::HTTP_OK))
            {
                $listData = json_decode($response->getBody()->getContents(), true);
                if(($listData['stat'] ?? '') == self::STATUS_OK)
                {
                    $result['status'] = true;
                    $result['data'] = $listData;
                }
                else
                {
                    $result['message'] = $listData['message'] ?? "Failed to get the Image List";
                }
            }
            else
            {
                $result['message'] = "Failed to get the Image List";
            }
        }
        catch (\Exception $exception)
        {
            $result['message'] = sprintf("Server Error: (%s)", $exception->getMessage());
        }
        return $result;
    }

    /**
     * @param $photoId
     * @return array
     */
    public function getImagesDescription($photoId)
    {
        $result = ['status' => false, 'message' => ""];
        $endpoint = sprintf("%s?method=flickr.photos.getInfo&api_key=%s&photo_id=%s&format=json&nojsoncallback=1", $this->apiUrl, $this->apiKey, $photoId);
        try
        {
            $client = new Client();
            $response = $client->get($endpoint);
            if($response instanceof ResponseInterface && ($response->getStatusCode() == Response::HTTP_OK))
            {
                $listData = json_decode($response->getBody()->getContents(), true);
                if(($listData['stat'] ?? '') == self::STATUS_OK)
                {
                    $result['status'] = true;
                    $result['data'] = $listData;
                }
                else
                {
                    $result['message'] = $listData['message'] ?? "Failed to get the Image Description";
                }
            }
            else
            {
                $result['message'] = "Failed to get the Image Description";
            }
        }
        catch (\Exception $exception)
        {
            $result['message'] = sprintf("Server Error: (%s)", $exception->getMessage());
        }
        return $result;
    }
}