<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;

class CourtController extends Controller
{
    public function index()
    {
        return view('courts.index');
    }

    public function getCourts(Request $request)
    {
        $columns = ['id', 'court_name', 'created_at', 'updated_at']; // Columns to be fetched

        $totalData = Court::count(); // Total records without filtering

        // Apply filtering if search value is provided
        $filteredData = Court::select($columns)
            ->where('court_name', 'like', '%' . $request->input('search')['value'] . '%')
            ->offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderBy($columns[$request->input('order')[0]['column']], $request->input('order')[0]['dir'])
            ->get();

        // Prepare data in DataTables compatible format
        $data = [];
        foreach ($filteredData as $row) {
            $data[] = [
                $row['id'],
                $row['court_name'],
                $row['created_at'],
                $row['updated_at'],
                // Add other fields as needed
                // For example: $row['field_name']
            ];
        }

        // Prepare response
        $response = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data,
        ];

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        $court = Court::create($request->all());

        // Return JSON response indicating success
        return response()->json(['message' => 'Court created successfully.', 'court' => $court], 201);
    }

    public function edit(Court $court)
    {
        // Return court data in JSON format
        return response()->json(['court' => $court]);
    }

    public function update(Request $request, Court $court)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        $court->update($request->all());

        // Return JSON response indicating success
        return response()->json(['message' => 'Court updated successfully.', 'court' => $court]);
    }
}
