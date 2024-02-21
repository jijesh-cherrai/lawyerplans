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

    public function create()
    {
        return view('courts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        Court::create($request->all());

        return redirect()->route('courts.index')
            ->with('success', 'Court created successfully.');
    }

    public function show(Court $court)
    {
        return view('courts.show', compact('court'));
    }

    public function edit(Court $court)
    {
        return view('courts.edit', compact('court'));
    }

    public function update(Request $request, Court $court)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
        ]);

        $court->update($request->all());

        return redirect()->route('courts.index')
            ->with('success', 'Court updated successfully');
    }

    public function destroy(Court $court)
    {
        $court->delete();

        return redirect()->route('courts.index')
            ->with('success', 'Court deleted successfully');
    }
}
