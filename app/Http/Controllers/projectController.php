<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Rules\YoutubeLink;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = project::get();

        return view('admin.project.index', [
            'project' => $project
        ]); //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = project::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('link', function ($row) {
                    $btn = '<a href="'.$row->link .'" data-projectid="' . $row->id . '" data-url = "' . route('project.update', $row->id) . '" >'.$row->link .'</a>';

                    return  $btn ;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-projectid="' . $row->id . '" data-url = "' . route('project.update', $row->id) . '" class="editproject btn btn-primary btn-sm"><?xml version="1.0" ?><svg class="feather feather-edit-3" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></a>
                           <a href="javascript:void(0)"  data-projectid="' . $row->id . '" class="deleteproject btn btn-danger btn-sm"><?xml version="1.0" ?><svg class="feather feather-trash-2" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a> ';

                    return $btn;
                })
                ->rawColumns(['action', 'link'])->toJson();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'link' => 'required',
        ]);
    
        // Extract the video ID from the URL
        $shortUrlRegex = '~youtu.be/([a-zA-Z0-9_-]+)\??~i';
        $longUrlRegex = '~youtube.com/((?:embed)|(?:watch))((?:\?v=)|(?:/))([a-zA-Z0-9_-]+)~i';
    
        $youtube_id = null;
    
        if (preg_match($longUrlRegex, $request->link, $matches)) {
            $youtube_id = $matches[3];
        } elseif (preg_match($shortUrlRegex, $request->link, $matches)) {
            $youtube_id = $matches[1];
        }
    
        if (!$youtube_id) {
            return response()->json(['error' => 'Invalid YouTube URL'], 400);
        }
    
        // Check if the link is already an embed URL, and if not, create one
        if (strpos($request->link, 'embed') === false) {
            $embedUrl = "https://www.youtube.com/embed/{$youtube_id}";
        } else {
            $embedUrl = $request->link; // URL is already in the correct format
        }
    
        $slide = Project::create([
            'name' => $request->name,
            'link' => $embedUrl,
        ]);
    
        return response()->json($slide, 200);
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

        $item = project::where('id',$id)->first();
        // dd($item);

        return $item ;

 } 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {


        $request->validate([
            'name' => 'required',
            'link' => [
                'required',
              
            ]
        ]);
       
        $shortUrlRegex = '~youtu.be/([a-zA-Z0-9_-]+)\??~i';
        $longUrlRegex = '~youtube.com/((?:embed)|(?:watch))((?:\?v=)|(?:/))([a-zA-Z0-9_-]+)~i';
        
        
        if (preg_match($longUrlRegex, $request->link, $matches)) {
            // The video ID from a long URL is in $matches[1]
            $youtube_id = $matches[1];
        } elseif (preg_match($shortUrlRegex, $request->link, $matches)) {
            // The video ID from a short URL is in $matches[1]
            $youtube_id = $matches[1];
        } else {
            // Neither pattern matched, handle the error or return an exception
            throw new Exception("Invalid YouTube URL");
        }
        
        // Now you have the YouTube video ID in $youtube_id
        
     

        $service = project::where('id', $id)->first();

        $service = $service->update([
            'name' => $request->name,
            'link' => $request->link
        ]);
        return  response()->json($service, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        project::find($id)->delete();
       
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
