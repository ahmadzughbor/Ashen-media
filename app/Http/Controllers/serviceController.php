<?php

namespace App\Http\Controllers;

use App\Models\service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            'title_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'image' => 'required | image | mimes:svg'
        ]);
        $file = $request->file('image'); // Replace 'image' with your input name
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/images', $fileName);
    
        $slide = service::create([
            'title' => $request->title ,
            'title_ar' => $request->title_ar, 
            'description' => $request->description ,
            'description_ar' => $request->description_ar ,
            'path'=> $fileName
        ]);
        return  response()->json($slide ,200);
     }

        public function update (Request $request , $id){

        
            $request->validate([
                'title' => 'required',
                'title_ar' => 'required',
                'description' => 'required',
                'description_ar' => 'required',
                'image' => 'nullable|image|mimes:svg'

            ]);
            $service = service::where('id' ,$id)->first();
            $file = $request->file('image'); // Replace 'file' with your input name

            if($file){
                if (File::exists('public/images/' . $service->path)) {
                    // Delete the file
                    File::delete($service->path);
                }
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                
            }else{
                $fileName = $service->path;
            }


            $service = $service->update([
                'title' => $request->title ,
                'title_ar' => $request->title_ar, 
                'description' => $request->description ,
                'description_ar' => $request->description_ar ,
                'path'=> $fileName

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
                     ->addColumn('title_ar', function($row){
                             return $row->title_ar;
                     })
                     ->addColumn('description', function($row){
                             return $row->description;
                     })
                     ->addColumn('description_ar', function($row){
                             return $row->description_ar;
                     }) 
                     ->addColumn('icon', function($row){
                        // dd($row->path);
                             $html=  "<img src=" .asset('storage/images/' . $row->path) . " width='40' height='40' alt='aa'>";
                             return $html; 
                     })
                     ->addColumn('action', function($row){
        
                         $btn = '<a href="javascript:void(0)" data-serviceid="'.$row->id .'" data-url = "'. route('service.update',$row->id ) .'" class="editservicee btn btn-primary btn-sm"><?xml version="1.0" ?><svg class="feather feather-edit-3" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></a>
                           <a href="javascript:void(0)"  data-serviceid="'.$row->id .'" class="deleteservice btn btn-danger btn-sm"><?xml version="1.0" ?><svg class="feather feather-trash-2" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a> ';
                         
                             return $btn;
                     })
                     ->rawColumns(['action','icon'])->toJson()
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
