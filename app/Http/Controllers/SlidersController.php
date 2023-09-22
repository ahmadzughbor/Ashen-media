<?php

namespace App\Http\Controllers;

use App\Models\sliders;
use Illuminate\Http\Request;
use DataTables;

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
        // $fileName = $file->getClientOriginalName();

        // $filenew = $file->move(public_path('/uploadedimages'), $fileName);
        // $newPath = public_path('uploadedimages/' . $fileName);
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/images', $fileName);

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
        
                         $btn = '<a href="javascript:void(0)" data-slideid="'.$row->id .'" data-url = "'. route('slider.update',$row->id ) .'" class="editSlide btn btn-primary btn-sm">edit</a>
                           <a href="javascript:void(0)"  data-slideid="'.$row->id .'" class="deleteSile btn btn-primary btn-sm">delete</a> ';
                         
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
