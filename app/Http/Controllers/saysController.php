<?php

namespace App\Http\Controllers;

use App\Models\say;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class saysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $say = say::get();

        return view('admin.say.index',[
            'say' => $say
        ]);//
    }

    public function data(Request $request)
     {
         if ($request->ajax()) {
             $data = say::select('*');
             return DataTables::of($data)
                     ->addIndexColumn()
                     ->addColumn('user_name', function($row){
                             return $row->user_name;
                     })
                     ->addColumn('company_name', function($row){
                             return $row->company_name;
                     })
                     ->addColumn('description', function($row){
                             return $row->description;
                     })
                     ->addColumn('action', function($row){
        
                         $btn = '<a href="javascript:void(0)" data-sayid="'.$row->id .'" data-url = "'. route('say.update',$row->id ) .'" class="editsay btn btn-primary btn-sm"><?xml version="1.0" ?><svg class="feather feather-edit-3" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></a>
                           <a href="javascript:void(0)"  data-sayid="'.$row->id .'" class="deletesay btn btn-danger btn-sm"><?xml version="1.0" ?><svg class="feather feather-trash-2" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a> ';
                         
                             return $btn;
                     })
                     ->rawColumns(['action','file'])->toJson()
                     ;
         }
           
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
    public function store(Request $request){

        $request->validate([
            'user_name' => 'required',
            'company_name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        $file = $request->file('image'); // Replace 'image' with your input name
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/images', $fileName);
    
        $say = say::create([
            'user_name' => $request->user_name ,
            'company_name' => $request->company_name ,
            'description' => $request->description ,
            'path' => $fileName

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
     public function edit($id) {

        $item = say::where('id',$id)->first();

        return $item ;

    } 

    /**
     * Update the specified resource in storage.
     */
    public function update (Request $request , $id){

       
        $request->validate([
            'user_name' => 'required',
            'company_name' => 'required',
            'description' => 'required'
        ]);

        $say = say::where('id' ,$id)->first();
        $file = $request->file('image'); // Replace 'file' with your input name

        if($file){
            if (File::exists('public/images/' . $say->path)) {
                // Delete the file
                File::delete($say->path);
            }
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            
            $file->storeAs('public/images', $fileName);
        }else{
            $fileName = $say->path;
        }

        $say = $say->update([
            'user_name' => $request->user_name ,
            'company_name' => $request->company_name ,
            'description' => $request->description ,
            'path' => $fileName

        ]);
        return  response()->json($say ,200);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        say::find($id)->delete();
       
        return response()->json(['success'=>'say deleted successfully.']);
    }
}
