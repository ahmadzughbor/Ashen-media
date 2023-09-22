<?php

namespace App\Http\Controllers;

use App\Models\peopleMessage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class peopleMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ContactUs.index'); //
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = peopleMessage::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->first_name ." ". $row->last_name ;
                })
               
                ->addColumn('Email', function ($row) {
                    return  $row->Email ;
                })
                ->addColumn('Phone', function ($row) {
                    return  $row->Phone ;
                })
                ->addColumn('Message', function ($row) {
                    return  $row->Message ;
                })
                ->rawColumns(['name'])->toJson();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'Email' => 'required | email',
            'Phone' => 'required',
            'Message' => 'required',
        ]);

    
        $say = peopleMessage::create([
            'first_name'=> $request->first_name,
            'last_name' =>  $request->last_name,
            'Email' =>  $request->Email,
            'Phone' => $request->Phone ,
            'Message' =>  $request->Message,
        ]);
        return  response()->json($say ,200);
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
