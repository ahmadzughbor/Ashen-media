<?php

namespace App\Http\Controllers;

use App\Models\service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class serviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = service::get();

        return view('admin.services.index',[
            'sliders' => $sliders
        ]);//
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create(){

    //     return view('admin.slider.create');
    //  }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){

        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

    
        $slide = service::create([
            'title' => $request->title ,
            'description' => $request->description 
        ]);
        return  response()->json($slide ,200);
     }

        public function update (Request $request , $id){

        
            $request->validate([
                'title' => 'required',
                'description' => 'required'
            ]);

            $service = service::where('id' ,$id)->first();

            $service = $service->update([
                'title' => $request->title,
                'description' => $request->description
            ]);
            return  response()->json($service ,200);
        }


     public function data(Request $request)
     {
         if ($request->ajax()) {
             $data = service::select('*');
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('title', function($row){
                             return $row->title;
                     })
                     ->addColumn('description', function($row){
                             return $row->description;
                     })
                     ->addColumn('action', function($row){
        
                         $btn = '<a href="javascript:void(0)" data-serviceid="'.$row->id .'" data-url = "'. route('service.update',$row->id ) .'" class="editservicee btn btn-primary btn-sm">edit</a>
                           <a href="javascript:void(0)"  data-serviceid="'.$row->id .'" class="deleteservice btn btn-primary btn-sm">delete</a> ';
                         
                             return $btn;
                     })
                     ->rawColumns(['action','file'])->toJson()
                     ;
         }
           
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
     */ public function edit($id) {

        $item = service::where('id',$id)->first();
        // dd($item);

        return $item ;

 } 


    /**
     * Update the specified resource in storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        service::find($id)->delete();
       
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
