<?php

namespace VitalSaaS\VitalCMSMinimal\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use VitalSaaS\VitalCMSMinimal\Models\CmsService;

class ServiceController extends Controller
{
    /**
     * Display a listing of active services.
     */
    public function index(Request $request): JsonResponse
    {
        $cacheKey = config('vitalcms.services.cache_key', 'vitalcms:services');
        $cacheTtl = config('vitalcms.cache.ttl', 3600);

        // Build query based on filters
        $query = CmsService::active()->ordered();

        // Filter by featured if requested
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->category($request->get('category'));
        }

        // Apply pagination if requested
        $perPage = $request->get('per_page', null);

        if ($perPage) {
            $services = $query->paginate($perPage);
            $data = $services->items();
            $meta = [
                'current_page' => $services->currentPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total(),
                'last_page' => $services->lastPage(),
            ];
        } else {
            // Cache key includes filters
            $fullCacheKey = $cacheKey . ':' . md5($request->getQueryString() ?? '');

            $data = Cache::remember($fullCacheKey, $cacheTtl, function () use ($query) {
                return $query->get();
            });

            $meta = [
                'count' => $data->count(),
                'cache_ttl' => $cacheTtl,
            ];
        }

        // Transform data
        $transformedData = collect($data)->map(function ($service) {
            return $this->transformService($service);
        });

        return response()->json([
            'success' => true,
            'data' => $transformedData,
            'meta' => $meta,
            'filters' => [
                'categories' => CmsService::getCategories(),
                'available_filters' => ['featured', 'category'],
            ]
        ]);
    }

    /**
     * Display the specified service.
     */
    public function show(CmsService $service): JsonResponse
    {
        if (!$service->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found or inactive',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->transformService($service, true),
        ]);
    }

    /**
     * Get featured services for homepage.
     */
    public function featured(): JsonResponse
    {
        $cacheKey = 'vitalcms:services:featured';
        $cacheTtl = config('vitalcms.cache.ttl', 3600);

        $services = Cache::remember($cacheKey, $cacheTtl, function () {
            return CmsService::active()
                ->featured()
                ->ordered()
                ->limit(6)
                ->get();
        });

        $transformedData = $services->map(function ($service) {
            return $this->transformService($service);
        });

        return response()->json([
            'success' => true,
            'data' => $transformedData,
            'meta' => [
                'count' => $transformedData->count(),
                'type' => 'featured',
            ]
        ]);
    }

    /**
     * Get services by category.
     */
    public function byCategory(string $category): JsonResponse
    {
        $services = CmsService::active()
            ->category($category)
            ->ordered()
            ->get();

        $transformedData = $services->map(function ($service) {
            return $this->transformService($service);
        });

        return response()->json([
            'success' => true,
            'data' => $transformedData,
            'meta' => [
                'count' => $transformedData->count(),
                'category' => $category,
                'category_name' => CmsService::getCategories()[$category] ?? ucfirst($category),
            ]
        ]);
    }

    /**
     * Transform service data for API response.
     */
    private function transformService(CmsService $service, bool $detailed = false): array
    {
        $baseData = [
            'id' => $service->id,
            'title' => $service->title,
            'slug' => $service->slug,
            'short_description' => $service->short_description,
            'price' => $service->price,
            'formatted_price' => $service->formatted_price,
            'price_description' => $service->price_description,
            'icon' => $service->icon_display,
            'image' => $service->image_url,
            'category' => $service->category,
            'category_name' => CmsService::getCategories()[$service->category] ?? 'Sin categoría',
            'featured' => $service->featured,
            'sort_order' => $service->sort_order,
        ];

        if ($detailed) {
            $baseData = array_merge($baseData, [
                'description' => $service->description,
                'meta_data' => $service->meta_data ?? [],
                'features' => $service->meta_data['features'] ?? [],
                'created_at' => $service->created_at?->toDateTimeString(),
                'updated_at' => $service->updated_at?->toDateTimeString(),
            ]);
        }

        return $baseData;
    }
}