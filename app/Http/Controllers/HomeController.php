<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Sector;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\WelcomeSection;
use App\Models\WhyChooseUsItem;
use Illuminate\Http\Request;
use VitalSaaS\VitalCMSMinimal\Models\CmsHeroSection;
use VitalSaaS\VitalCMSMinimal\Models\CmsService;

class HomeController extends Controller
{
    public function index()
    {
        $heroSections = CmsHeroSection::active()
            ->ordered()
            ->get();

        $welcomeSection = WelcomeSection::active()
            ->ordered()
            ->first();

        $whyChooseUs = WhyChooseUsItem::active()
            ->ordered()
            ->get();

        $featuredServices = CmsService::featured()
            ->ordered()
            ->take(6)
            ->get();

        $allServices = CmsService::active()
            ->ordered()
            ->get();

        $sectors = Sector::active()
            ->ordered()
            ->get();

        $stats = Stat::active()
            ->ordered()
            ->get();

        $featuredProjects = Project::active()
            ->featured()
            ->ordered()
            ->take(6)
            ->get();

        $testimonials = Testimonial::active()
            ->ordered()
            ->get();

        $latestPosts = Post::published()
            ->latestFirst()
            ->take(3)
            ->get();

        return view("home", compact(
            "heroSections",
            "welcomeSection",
            "whyChooseUs",
            "featuredServices",
            "allServices",
            "sectors",
            "stats",
            "featuredProjects",
            "testimonials",
            "latestPosts"
        ));
    }
}
