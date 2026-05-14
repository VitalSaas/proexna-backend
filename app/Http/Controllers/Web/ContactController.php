<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use VitalSaaS\VitalCMSMinimal\Models\CmsContactSubmission;
use VitalSaaS\VitalCMSMinimal\Models\CmsService;

class ContactController extends Controller
{
    /**
     * Display contact page.
     */
    public function index()
    {
        // Obtener categorías únicas de servicios activos
        $services = CmsService::active()
            ->select("category")
            ->distinct()
            ->whereNotNull("category")
            ->orderBy("category")
            ->get()
            ->pluck("category")
            ->mapWithKeys(function ($category) {
                return [$category => ucfirst(str_replace(["_", "-"], " ", $category))];
            });
            
        return view("contact.index", compact("services"));
    }
    
    /**
     * Store contact form submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "max:255"],
            "phone" => ["nullable", "string", "max:20"],
            "subject" => ["nullable", "string", "max:255"],
            "message" => ["required", "string", "max:2000"],
            "service_interest" => ["nullable", "string", "max:100"],
        ]);
        
        $contact = CmsContactSubmission::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "subject" => $request->subject,
            "message" => $request->message,
            "service_interest" => $request->service_interest,
            "status" => "new",
            "ip_address" => $request->ip(),
            "user_agent" => $request->userAgent(),
        ]);
        
        return back()->with("success", "¡Gracias por contactarnos! Te responderemos pronto.");
    }
}
