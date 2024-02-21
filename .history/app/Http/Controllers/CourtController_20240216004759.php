<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use DataTables;

class CourtController extends Controller
{
    public function index()
    {
        return view('courts.index');
    }

    public function getCourts(Request $request)
    {
        // Base query
        $query = Court::query();

        // Define columns to be fetched
        $columns = ['id', 'court_name', 'created_at', 'updated_at'];

        // Define DataTables query
        $dataTable = DataTables::of($query)
            ->addColumn('actions', function ($court) {
                // Add actions column content here if needed
            });

        // Add search filtering
        if (!empty($request->input('search')['value'])) {
            $dataTable->filter(function ($query) use ($request) {
                $query->where('court_name', 'like', '%' . $request->input('search')['value'] . '%');
            });
        }

        // Return DataTables response
        return $dataTable->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        $court = Court::create($request->all());

        // Return a response indicating success
        return response()->json(['message' => 'Court created successfully.', 'court' => $court], 201);
    }

    public function edit(Court $court)
    {
        // Return the court data in JSON format
        return response()->json(['court' => $court]);
    }
}
