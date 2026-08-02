<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalTeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalTeamController extends Controller
{
    public function index()
    {
        $chiefEditors = JournalTeamMember::chiefEditors()->orderBy('order', 'asc')->paginate(10);
        $editors = JournalTeamMember::editors()->orderBy('order', 'asc')->paginate(10);
        $reviewers = JournalTeamMember::reviewers()->orderBy('order', 'asc')->paginate(10);
        
        return view('admin.journal-team.index', compact('chiefEditors', 'editors', 'reviewers'));
    }

    public function create()
    {
        return view('admin.journal-team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:chief_editor,editor,reviewer',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'nullable|url|max:500',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $data = $request->except('photo');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('journal-team/photos', 'public');
            $data['photo'] = $photoPath;
        }

        JournalTeamMember::create($data);

        return redirect()->route('admin.journal-team.index')
            ->with('success', 'Team member created successfully.');
    }

    public function edit(JournalTeamMember $journalTeam)
    {
        return view('admin.journal-team.edit', compact('journalTeam'));
    }

    public function update(Request $request, JournalTeamMember $journalTeam)
    {
        $request->validate([
            'type' => 'required|in:chief_editor,editor,reviewer',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'qualification' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'nullable|url|max:500',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        $data = $request->except('photo');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($journalTeam->photo) {
                Storage::disk('public')->delete($journalTeam->photo);
            }
            
            $photoPath = $request->file('photo')->store('journal-team/photos', 'public');
            $data['photo'] = $photoPath;
        }

        // If remove photo is checked
        if ($request->has('remove_photo')) {
            if ($journalTeam->photo) {
                Storage::disk('public')->delete($journalTeam->photo);
            }
            $data['photo'] = null;
        }

        $journalTeam->update($data);

        return redirect()->route('admin.journal-team.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(JournalTeamMember $journalTeam)
    {
        // Delete photo if exists
        if ($journalTeam->photo) {
            Storage::disk('public')->delete($journalTeam->photo);
        }

        $journalTeam->delete();

        return redirect()->route('admin.journal-team.index')
            ->with('success', 'Team member deleted successfully.');
    }
}