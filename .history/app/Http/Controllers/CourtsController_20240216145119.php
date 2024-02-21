<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Court;
use DataTables;

class CourtsController extends Controller
{
    public function index()
    {
        return view('courts.index');
    }

    public function get()
    {
        return DataTables::of(Court::query())
            ->addColumn('actions', function ($court) {
                return '<button type="button" class="btn btn-primary btn-sm editCourtButton" data-id="' . $court->id . '" data-court_name="' . $court->court_name . '">
                <i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-danger deleteCourtButton" data-id="' . $court->id . '">Delete</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        $court = Court::create($request->all());

        return response()->json(['message' => 'Court created successfully']);
    }

    public function update(Request $request, Court $court)
    {
        // dd($court);
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        $court->update($request->all());

        return response()->json(['message' => 'Court updated successfully']);
    }

    public function destroy(Court $court)
    {
        $court->delete();

        return response()->json(['message' => 'Court deleted successfully']);
    }
}
