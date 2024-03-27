<?php

namespace App\Http\Controllers;

use App\Models\aboutsection;
use App\Models\goalssection;
use App\Models\missionsection;
use App\Models\Visionsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class aboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $aboutus = aboutsection::first();

        return view('admin.about.Aboutus', compact('aboutus'));
    }
    public function indexVision()
    {

        $ourvision = Visionsection::first();

        return view('admin.about.ourvision', compact('ourvision'));
    }
    public function indexmission()
    {

        $ourmission = missionsection::first();
        // dd($ourmission);
        return view('admin.about.ourmission', compact('ourmission'));
    }
    public function indexgoals()
    {

        $ourgoals = goalssection::first();
        // dd($ourmission);
        return view('admin.about.ourgoals', compact('ourgoals'));
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
       
        $aboutus = aboutsection::first();

        $file = $request->file('file'); // Replace 'file' with your input name
        
        if($file){
            if (File::exists('public/images/' . $aboutus->path)) {
                // Delete the file
                File::delete($aboutus->path);
            }
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/images', $fileName);
        }else{
            $fileName = $aboutus->path;
        }
        if ($aboutus) {
           
            $aboutus = $aboutus->update([
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'path' => $fileName
            ]);
        }else{
            $request->validate([
                'description' => 'required',
                'description_ar' => 'required',
                'file' => 'required|image'
            ]);
            $aboutus =aboutsection::create([
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'path' => $fileName
            ]);

        }
        return $aboutus;
    }
    public function storeVision(Request $request)
    {
       
        $Vision = Visionsection::first();
        $file = $request->file('file'); // Replace 'file' with your input name
        if($file){
            if (File::exists('public/images/' . $Vision->path)) {
                // Delete the file
                File::delete($Vision->path);
            }
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/images', $fileName);
        }else{
            $fileName = $Vision->path;
        }
        if ($Vision) {
            
             $Vision->update([
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'path' => $fileName
            ]);
        }else{
            $request->validate([
                'description' => 'required',
                'description_ar' => 'required',
                'file' => 'required|image'
            ]);
            $Vision =Visionsection::create([
                'description' => $request->description,
                'description_ar' => $request->description_ar,

                'path' => $fileName
            ]);

        }
        return $Vision;
    }
    public function storemission(Request $request)
    {
      
        $mission = missionsection::first();
        $file = $request->file('file'); // Replace 'file' with your input name
        
        if($file){
            if (File::exists('public/images/' . $mission->path)) {
                // Delete the file
                File::delete($mission->path);
            }
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/images', $fileName);
        }else{
            $fileName = $mission->path;
        }
        
        if ($mission) {
            
            $mission->update([
                'description' => $request->description,
                'description_ar' => $request->description_ar,

                'path' => $fileName
            ]);
        }else{
            $request->validate([
                'description' => 'required',
                'description_ar' => 'required',
                'file' => 'required|image'
            ]);
            $mission =missionsection::create([
                'description' => $request->description,
                'description_ar' => $request->description_ar,

                'path' => $fileName
            ]);

        }
        return $mission;
    }
    public function storegoals(Request $request)
    {
        
        $goals = goalssection::first();
        $file = $request->file('file'); // Replace 'file' with your input name
        if($file){
            if (File::exists('public/images/' . $goals->path)) {
                // Delete the file
                File::delete($goals->path);
            }
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/images', $fileName);
        }else{
            $fileName = $goals->path;
        }

        
        if ($goals) {
            
            $goals->update([
                'description' => $request->description,
                'description_ar' => $request->description_ar,
                'path' => $fileName
            ]);
        }else{
            $request->validate([
                'description' => 'required',
                'description_ar' => 'required',
                'file' => 'required|image'
            ]);
            $goals =goalssection::create([
                'description' => $request->description,
                'description_ar' => $request->description_ar,

                'path' => $fileName
            ]);

        }
        return $goals;
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
