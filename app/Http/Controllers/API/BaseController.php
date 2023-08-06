<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class BaseController extends Controller
{
    /**
     * API version for content negotiation.
     *
     * @var string
     */
    protected $apiVersion = 'v1';

    /**
     * Create a JSON response for successful operations.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     */
    protected function sendResponse($data, $message = 'Success', $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
            'version' => $this->apiVersion,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Create a JSON response for errors.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @param  int|null  $errorCode
     */
    protected function sendError($message, $statusCode = 400, $errorCode = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'version' => $this->apiVersion,
        ];

        if ($errorCode !== null) {
            $response['error_code'] = $errorCode;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Get the client's preferred response format based on Accept header.
     *
     * @param  array  $formats
     * @param  string|null  $default
     */
    protected function getPreferredFormat($formats, $default = null): string
    {
        $acceptHeader = Request::header('Accept');

        foreach ($formats as $format) {
            if (Str::contains($acceptHeader, $format)) {
                return $format;
            }
        }

        return $default ?? $formats[0];
    }

    /**
     * Check if the request is an API OPTIONS request for content negotiation.
     */
    protected function isOptionsRequest(): bool
    {
        return Request::isMethod('OPTIONS');
    }

    /**
     * Enable caching for a JSON response with a custom cache key.
     *
     * @param  mixed  $data
     * @param  string  $cacheKey
     * @param  int  $expirationInMinutes
     */
    protected function cacheResponse($data, $cacheKey, $expirationInMinutes = 60): JsonResponse
    {
        return Cache::remember($cacheKey, $expirationInMinutes, function () use ($data) {
            return $this->sendResponse($data);
        });
    }

    /**
     * Add HATEOAS links to the response.
     *
     * @param  array  $links
     */
    protected function addHateoasLinks($links, JsonResponse $response): JsonResponse
    {
        $data = $response->getData(true);
        $data['_links'] = $links;
        $response->setData($data);

        return $response;
    }
}
