<?php

namespace App\Http\Controllers;

use App\Models\package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class packagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = package::get();

        return view('admin.packages.index', [
            'packages' => $packages
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = package::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('amount', function ($row) {
                    return $row->amount;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-packageid="' . $row->id . '" data-url = "' . route('packages.update', $row->id) . '" class="editproject btn btn-primary btn-sm"><?xml version="1.0" ?><svg class="feather feather-edit-3" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></a>
                           <a href="javascript:void(0)"  data-packageid="' . $row->id . '" class="deletepackage btn btn-danger btn-sm"><?xml version="1.0" ?><svg class="feather feather-trash-2" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a> ';

                    return $btn;
                })
                ->rawColumns(['action'])->toJson();
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
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'featureNames' => 'required|array',
            'featureValues' => 'required|array',
            'featureNames.*' => 'string|max:255',
            'featureValues.*' => 'string|max:255',
        ]);
        $package = null; // Define $package before the try block

        try {
            DB::transaction(function () use ($request, &$package) {

                // Create a new package instance
                $package = new Package();
                $package->name = $request->input('name');
                $package->amount = $request->input('amount');
                $package->save();

                // Store features for the package
                $featureNames = $request->input('featureNames');
                $featureValues = $request->input('featureValues');

                foreach ($featureNames as $index => $featureName) {
                    $featureValue = $featureValues[$index];

                    // Create and associate the feature with the package
                    $package->features()->create([
                        'name' => $featureName,
                        'value' => $featureValue,
                    ]);
                }
            });

            // Redirect to a success page or return a response
            return response()->json($package, 200);
        } catch (\Exception $e) {
            // Handle any exceptions here, such as rolling back the transaction
            return response()->json(['error' => $e->getMessage()], 500);
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
     */
    public function edit($id)
    {

        $Package = Package::where('id', $id)->with('features')->first();
        // dd($item);

        return $Package;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'featureNames' => 'array',
            'featureValues' => 'array',
            'featureNames.*' => 'string|max:255',
            'featureValues.*' => 'string|max:255',
        ]);

        // Fetch the existing package to update
        $package = Package::findOrFail($id);

        // Update the package attributes
        $package->name = $request->input('name');
        $package->amount = $request->input('amount');
        $package->save();

        // Delete existing features (if needed)
        $package->features()->delete();

        // Store new features for the package
        $featureNames = $request->input('featureNames');
        $featureValues = $request->input('featureValues');
        if($featureNames != null ){

            foreach ($featureNames as $index => $featureName) {
                $featureValue = $featureValues[$index];
                
                // Create and associate the feature with the package
                $package->features()->create([
                    'name' => $featureName,
                    'value' => $featureValue,
                ]);
            }
        }


        // Redirect to a success page or return a response
        return response()->json($package, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $package = Package::find($id);

        // Delete the package and its associated features
        $package->features()->delete();
        $package->delete();
    
        // Redirect to a success page or return a response
        return response()->json(['message' => 'Package and features deleted successfully'], 200);
    }

}
