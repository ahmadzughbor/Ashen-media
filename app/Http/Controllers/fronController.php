<?php

namespace App\Http\Controllers;

use App\Models\aboutsection;
use App\Models\goalssection;
use App\Models\missionsection;
use App\Models\package;
use App\Models\partner;
use App\Models\project;
use App\Models\say;
use App\Models\service;
use App\Models\settings;
use App\Models\sliders;
use App\Models\Statistic;
use App\Models\Visionsection;
use Illuminate\Http\Request;

class fronController extends Controller
{
    public function index()
    {

        $sliders = sliders::get();
        $ourgoals = goalssection::first();
        $ourmission = missionsection::first();
        $ourvision = Visionsection::first();
        $aboutus = aboutsection::first();
        $services = service::get();
        $says = say::get();
        $partners = partner::get();
        $Statistic = Statistic::first();
        $projects = project::latest()->take(3)->get();
        $packages = package::with('features')->latest()->take(4)->get();
        $settings = settings::first();

       


        return view('frontEnd.index', compact('settings', 'partners', 'says', 'packages', 'Statistic', 'projects', 'sliders', 'ourgoals', 'ourmission', 'ourvision', 'aboutus', 'services'));
    }
}
