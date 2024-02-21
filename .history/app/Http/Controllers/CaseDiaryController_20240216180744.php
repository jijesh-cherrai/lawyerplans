<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseDiary;
use Datatables;
class CaseDiaryController extends Controller
{
    public function index()
    {
        return view('case-diaries.index');
    }

    public function getCaseDiaries()
    {
        // $caseDiaries = CaseDiary::with('court')->get();
        // return datatables()->of($caseDiaries)->make(true);
        return DataTables::of(CaseDiary::with('court')->query())
        ->addColumn('actions', function ($caseDiary) {
            return '<button type="button" class="btn btn-primary btn-sm editCaseDiaryButton" data-id="' . $caseDiary->id . '"><i class="fa fa-edit"></i> Edit</button>
                    <button type="button" class="btn btn-danger btn-sm deleteCaseDiaryButton" data-id="' . $caseDiary->id . '"><i class="fa fa-trash"></i> Delete</button>';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'case_number' => 'required|string',
            'court_id' => 'required|exists:courts,id',
            'party_names' => 'required|string',
            'case_date' => 'required|date',
            'purpose' => 'required|string',
        ]);

        // Create new case diary
        CaseDiary::create($request->all());

        return response()->json(['message' => 'Case diary created successfully.']);
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'case_number' => 'required|string',
            'court_id' => 'required|exists:courts,id',
            'party_names' => 'required|string',
            'case_date' => 'required|date',
            'purpose' => 'required|string',
        ]);

        // Update case diary
        $caseDiary = CaseDiary::findOrFail($id);
        $caseDiary->update($request->all());

        return response()->json(['message' => 'Case diary updated successfully.']);
    }

    public function show($id)
    {
        // Fetch case diary by ID
        $caseDiary = CaseDiary::findOrFail($id);

        return response()->json($caseDiary);
    }

    public function destroy($id)
    {
        // Delete case diary
        $caseDiary = CaseDiary::findOrFail($id);
        $caseDiary->delete();

        return response()->json(['message' => 'Case diary deleted successfully.']);
    }
}
