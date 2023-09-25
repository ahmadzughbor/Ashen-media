<?php

namespace App\Http\Controllers;

use App\Models\say;
use Illuminate\Http\Request;
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
        
                         $btn = '<a href="javascript:void(0)" data-sayid="'.$row->id .'" data-url = "'. route('say.update',$row->id ) .'" class="editsay btn btn-primary btn-sm">edit</a>
                           <a href="javascript:void(0)"  data-sayid="'.$row->id .'" class="deletesay btn btn-primary btn-sm">delete</a> ';
                         
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
