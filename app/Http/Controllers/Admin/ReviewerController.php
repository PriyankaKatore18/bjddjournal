<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reviewer;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    public function index()
    {
        $reviewers = Reviewer::all();
        return view('admin.reviewers.index', compact('reviewers'));
    }

    public function create()
    {
        return view('admin.reviewers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:reviewers',
            'expertise'  => 'nullable|string|max:255',
            'affiliation'=> 'nullable|string|max:255',
        ]);

        Reviewer::create($request->all());
        return redirect()->route('admin.reviewers.index')->with('success', 'Reviewer added successfully.');
    }

    public function edit(Reviewer $reviewer)
    {
        return view('admin.reviewers.edit', compact('reviewer'));
    }

    public function update(Request $request, Reviewer $reviewer)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:reviewers,email,' . $reviewer->id,
            'expertise'  => 'nullable|string|max:255',
            'affiliation'=> 'nullable|string|max:255',
        ]);

        $reviewer->update($request->all());
        return redirect()->route('admin.reviewers.index')->with('success', 'Reviewer updated successfully.');
    }

    public function destroy(Reviewer $reviewer)
    {
        $reviewer->delete();
        return redirect()->route('admin.reviewers.index')->with('success', 'Reviewer deleted successfully.');
    }
}
