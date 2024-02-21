<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseDiary;

class CaseDiaryController extends Controller
{
    public function index()
    {
        return view('case-diaries.index');
    }

    public function getCaseDiaries(Request $request)
    {
        if ($request->ajax()) {
            $data = CaseDiary::latest()->get();
            return datatables()->of($data)
                ->addColumn('court_name', function ($row) {
                    return $row->court->court_name;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-info btn-sm editCaseDiary">Edit</a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm deleteCaseDiary">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'case_number' => 'required',
            'court_id' => 'required',
            'party_names' => 'required',
            'case_date' => 'required',
            'purpose' => 'required',
        ]);

        CaseDiary::updateOrCreate(['id' => $request->case_diary_id], $validatedData);

        return response()->json(['success' => 'Case Diary saved successfully.']);
    }

    public function edit($id)
    {
        $caseDiary = CaseDiary::find($id);
        return response()->json($caseDiary);
    }

    public function destroy($id)
    {
        CaseDiary::find($id)->delete();
        return response()->json(['success' => 'Case Diary deleted successfully.']);
    }
}
