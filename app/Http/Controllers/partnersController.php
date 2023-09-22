<?php

namespace App\Http\Controllers;

use App\Models\partner;
use Illuminate\Http\Request;
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
        // $fileName = $file->getClientOriginalName();

        // $filenew = $file->move(public_path('/uploadedimages'), $fileName);
        // $newPath = public_path('uploadedimages/' . $fileName);
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/images', $fileName);

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
                           <a href="javascript:void(0)"  data-partnerid="' . $row->id . '" class="deletepartner btn btn-primary btn-sm">delete</a> ';

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
