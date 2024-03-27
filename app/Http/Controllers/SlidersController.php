<?php

namespace App\Http\Controllers;

use App\Models\sliders;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SlidersController extends Controller
{
     public function index(){
        $sliders = sliders::get();
        return view('admin.slider.slider',[
            'sliders' => $sliders
        ]);
     }
     public function create(){

        return view('admin.slider.create');
     }

     public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'file' => 'required|image'
        ]);

        $file = $request->file('file'); // Replace 'file' with your input name
        // $fileName = $file->getClientOriginalName();

        // $filenew = $file->move(public_path('/uploadedimages'), $fileName);
        // $newPath = public_path('uploadedimages/' . $fileName);
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/images', $fileName);

        $slide = sliders::create([
            'name' => $request->name ,
            'path' => $fileName
        ]);
        return  response()->json($slide ,200);
     }
     public function update (Request $request , $id){

        $request->validate([
            'name' => 'required',
            'file' => 'image'
        ]);
        $item = sliders::where('id' ,$id)->first();
        $file = $request->file('file'); // Replace 'file' with your input name
        $fileName = null;
        if($request->file('file')){
            if (File::exists('public/images/' . $item->path)) {
                // Delete the file
                File::delete($item->path);
            }
            // $fileName = $file->getClientOriginalName();
            
            // $filenew = $file->move(public_path('/uploadedimages'), $fileName);
            // $newPath = public_path('uploadedimages/' . $fileName);
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/images', $fileName);
        }else{
            $fileName = $item->path;
        }

        $slide = $item->update([
            'name' => $request->name ,
            'path' => $fileName
        ]);
        return  response()->json($slide ,200);
     }
     public function data(Request $request)
     {
         if ($request->ajax()) {
             $data = sliders::select('*');
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('name', function($row){
                             return $row->name;
                     })
                     ->addColumn('file', function($row){
                        // dd($row->path);
                             $html=  "<img src=" .asset('storage/images/' . $row->path) . " width='40' height='40' alt='aa'>";
                             return $html; 
                     })
                     ->addColumn('action', function($row){
        
                         $btn = '<a href="javascript:void(0)" data-slideid="'.$row->id .'" data-url = "'. route('slider.update',$row->id ) .'" class="editSlide btn btn-primary btn-sm"><?xml version="1.0" ?><svg class="feather feather-edit-3" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></a>
                           <a href="javascript:void(0)"  data-slideid="'.$row->id .'" class="deleteSile btn btn-danger btn-sm"><?xml version="1.0" ?><svg class="feather feather-trash-2" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a> ';
                         
                             return $btn;
                     })
                     ->rawColumns(['action','file'])->toJson()
                     ;
         }
           
     }

     public function edit($id) {

            $item = sliders::where('id',$id)->first();
            // dd($item);

            return $item ;

     } 


     public function destroy($id)
     {
        sliders::find($id)->delete();
       
         return response()->json(['success'=>'Product deleted successfully.']);
     }
}
