<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VitalSaaS\VitalCMSMinimal\Models\CmsHeroSection;
use VitalSaaS\VitalCMSMinimal\Models\CmsService;

class HomeController extends Controller
{
    /**
     * Display the homepage with hero sections and featured services.
     */
    public function index()
    {
        $heroSections = CmsHeroSection::active()
            ->ordered()
            ->get();

        $featuredServices = CmsService::featured()
            ->ordered()
            ->take(6)
            ->get();

        $allServices = CmsService::active()
            ->ordered()
            ->get();

        return view("home", compact("heroSections", "featuredServices", "allServices"));
    }
}
