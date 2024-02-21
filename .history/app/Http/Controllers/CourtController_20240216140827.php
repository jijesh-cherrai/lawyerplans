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
        if ($request->ajax()) {
            $data = Court::latest()->get();
            return datatables()->of($data)
                ->addColumn('actions', function ($row) {
                    $editBtn = '<button type="button" class="btn btn-primary btn-sm editCourtButton" data-court-name="'. $row->court_name .'" data-id="' . $row->id . '">Edit</button>';
                    $deleteBtn = '<button type="button" class="btn btn-danger btn-sm deleteCourtButton" data-court-name="'. $row->court_name .'" data-id="' . $row->id . '">Delete</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        Court::create($request->all());

        return response()->json(['message' => 'Court created successfully']);
    }

    public function update(Request $request, Court $court)
    {
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
