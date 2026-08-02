<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;

class ContactSubmissionController extends Controller
{
    // Show all submissions
    public function index()
    {
        $submissions = ContactSubmission::latest()->paginate(10); 
        return view('admin.contact-submissions.index', compact('submissions'));
    }

    // Optionally, view single submission
    public function show($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        return view('admin.contact-submissions.show', compact('submission'));
    }

    // Delete a submission
    public function destroy($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->delete();
        return redirect()->route('admin.contact-submissions.index')
            ->with('success', 'Submission deleted successfully.');
    }
}
