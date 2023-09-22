<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;

class statisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $Statistic = Statistic::first();

        return view('admin.Statistic.index', compact('Statistic'));
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
       
        $Statistic = Statistic::first();

        

        if ($Statistic) {

            $Statistic = $Statistic->update([
                'num1' => $request->num1,
                'section1' => $request->section1,
                'num2'  => $request->num2,
                'section2'  => $request->section2,
                'num3'  => $request->num3,
                'section3' => $request->section3,
                'num4'  => $request->num4,
                'section4' => $request->section4,
            ]);
        }else{
            $Statistic =Statistic::create([
                'num1' => $request->num1,
                'section1' => $request->section1,
                'num2'  => $request->num2,
                'section2'  => $request->section2,
                'num3'  => $request->num3,
                'section3' => $request->section3,
                'num4'  => $request->num4,
                'section4' => $request->section4,
            ]);

        }
        return $Statistic;
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
