<?php

namespace App\Http\Controllers;

use App\Models\settings;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $settings = settings::first();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $settings = settings::first();

        
        if ($settings) {
            
            $settings->update([
                'whatsappLink' => $request->whatsappLink,
                'instagramLink' => $request->instagramLink,
                'facebookLink'  => $request->facebookLink,
                'twitterLink'  => $request->twitterLink,
                'tiktokLink'  => $request->tiktokLink,
                'snapchatLink' => $request->snapchatLink,

            ]);
        } else {
            settings::create([
                'whatsappLink' => $request->whatsappLink,
                'instagramLink' => $request->instagramLink,
                'facebookLink'  => $request->facebookLink,
                'twitterLink'  => $request->twitterLink,
                'tiktokLink'  => $request->tiktokLink,
                'snapchatLink' => $request->snapchatLink,
            ]);
        }
        // dd($request->snapchatLink);
        return $settings;
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
