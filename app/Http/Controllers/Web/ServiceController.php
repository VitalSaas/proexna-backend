<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use VitalSaaS\VitalCMSMinimal\Models\CmsService;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = CmsService::active()->ordered()->get();
        $featuredServices = CmsService::featured()->active()->ordered()->get();
        $categories = CmsService::active()
            ->select("category")
            ->whereNotNull("category")
            ->distinct()
            ->pluck("category")
            ->sort()
            ->values();

        return view("services.index", [
            "services" => $services,
            "featuredServices" => $featuredServices,
            "categories" => $categories
        ]);
    }

    public function show(CmsService $service)
    {
        if (!$service->is_active) {
            abort(404);
        }

        return view("services.show", [
            "service" => $service,
            "relatedServices" => CmsService::active()
                ->where("category", $service->category)
                ->where("id", "!=", $service->id)
                ->ordered()
                ->take(3)
                ->get()
        ]);
    }

    public function category(string $category)
    {
        $services = CmsService::active()
            ->category($category)
            ->ordered()
            ->get();

        return view("services.category", [
            "services" => $services,
            "category" => $category,
            "categories" => CmsService::active()
                ->select("category")
                ->whereNotNull("category")
                ->distinct()
                ->pluck("category")
                ->sort()
                ->values()
        ]);
    }
}
