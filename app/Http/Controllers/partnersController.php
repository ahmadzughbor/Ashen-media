<?php

namespace App\Http\Controllers;

use App\Models\partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class partnersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = partner::get();
        return view('admin.partners.index', [
            'partners' => $partners
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'file' => 'required|image'
        ]);

        $file = $request->file('file'); // Replace 'file' with your input name
 
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/images', $fileName);

        $slide = partner::create([
            'path' => $fileName
        ]);
        return  response()->json($slide, 200);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'file' => 'image'
        ]);
        $item = partner::where('id', $id)->first();
        $file = $request->file('file'); // Replace 'file' with your input name
        if($file){
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
            'path' => $fileName
        ]);
        return  response()->json($slide, 200);
    }
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = partner::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('file', function ($row) {
                    // dd($row->path);
                    $html =  "<img src=" . asset('storage/images/' . $row->path) . " width='40' height='40' alt='aa'>";
                    return $html;
                })
                ->addColumn('action', function ($row) {

                    $btn = '
                           <a href="javascript:void(0)"  data-partnerid="' . $row->id . '" class="deletepartner btn btn-danger btn-sm"><?xml version="1.0" ?><svg class="feather feather-trash-2" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a> ';

                    return $btn;
                })
                ->rawColumns(['action', 'file'])->toJson();
        }
    }

    public function edit($id)
    {

        $item = partner::where('id', $id)->first();
        // dd($item);

        return $item;
    }


    public function destroy($id)
    {
        partner::find($id)->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
