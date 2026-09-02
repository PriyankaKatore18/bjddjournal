<?php

namespace App\Http\Controllers;

use App\Models\PaperSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaperSubmissionController extends Controller
{
    // ---------- FRONTEND ----------
    public function showForm()
    {
        return view('submit-paper');
    }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                  => 'required|string|max:255',
            'paper_file'             => 'required|mimes:doc,docx|max:10240', // 10MB
            'research_area'          => 'required|string|max:255',
            'author_main_name'       => 'required|string|max:255',
            'author_main_designation'=> 'required|string|max:255',
            'author_main_institute'  => 'required|string|max:255',
            'author_main_email'      => 'required|email|max:255', // This should accept all valid emails
            'author_main_mobile'     => 'required|string|max:20',
            'address_line1'          => 'required|string|max:255',
            'address_line2'          => 'nullable|string|max:255',
            'city'                   => 'required|string|max:100',
            'state'                  => 'required|string|max:100',
            'country'                => 'required|string|max:100',
            'pincode'                => 'required|string|max:20',
            'declaration'            => 'accepted',
            'verification_answer'    => 'required',
            'verification_correct_answer' => 'required',
            'co_authors'             => 'nullable|array|max:3',
            'co_authors.*.name'      => 'nullable|required_with:co_authors.*.email|string|max:255',
            'co_authors.*.email'     => 'nullable|email|max:255', // This should also accept all valid emails
            'co_authors.*.mobile'    => 'nullable|string|max:20',
        ], [
            'paper_file.required' => 'The paper file is required.',
            'paper_file.mimes' => 'The paper file must be a Word document (doc or docx).',
            'paper_file.max' => 'The paper file must not exceed 10MB.',
            'declaration.accepted' => 'You must accept the declaration.',
            'co_authors.*.name.required_with' => 'Co-author name is required when email is provided.',
            'author_main_email.email' => 'Please provide a valid email address.',
            'co_authors.*.email.email' => 'Please provide a valid email address for co-author.',
        ]);

        // Add custom verification for math problem
        $validator->after(function ($validator) use ($request) {
            $userAnswer = $request->input('verification_answer');
            $correctAnswer = $request->input('verification_correct_answer');
            
            if ($userAnswer != $correctAnswer) {
                $validator->errors()->add('verification_answer', 'The verification answer is incorrect. Please try again.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $submission = new PaperSubmission();
            $submission->title = $request->title;
            $submission->research_area = $request->research_area;

            // Save main author details
            $submission->author_main_name = $request->author_main_name;
            $submission->author_main_designation = $request->author_main_designation;
            $submission->author_main_institute = $request->author_main_institute;
            $submission->author_main_email = $request->author_main_email;
            $submission->author_main_mobile = $request->author_main_mobile;

            // Save address
            $submission->address_line1 = $request->address_line1;
            $submission->address_line2 = $request->address_line2;
            $submission->city = $request->city;
            $submission->state = $request->state;
            $submission->country = $request->country;
            $submission->pincode = $request->pincode;

            // Save co-authors (store as JSON in DB)
            if ($request->filled('co_authors')) {
                $validCoAuthors = array_filter($request->co_authors, function($coAuthor) {
                    return !empty($coAuthor['name']) || !empty($coAuthor['email']);
                });
                $submission->co_authors = json_encode($validCoAuthors);
            }

            // Save file
            if ($request->hasFile('paper_file')) {
                $submission->file_path = $request->file('paper_file')->store('submissions', 'public');
            }

            $submission->status = 'submitted';
            $submission->save();

            return redirect()->back()->with('success', 'Your paper has been submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while submitting your paper. Please try again.')
                ->withInput();
        }
    }

    // ---------- ADMIN ----------
    public function index()
    {
        $submissions = PaperSubmission::latest()->paginate(10);
        return view('admin.submissions.index', compact('submissions'));
    }

    public function create()
    {
        return view('admin.submissions.create');
    }

    public function edit(PaperSubmission $submission)
    {
        return view('admin.submissions.edit', compact('submission'));
    }

    public function update(Request $request, PaperSubmission $submission)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'research_area' => 'required|string|max:255',
            'author_main_name' => 'required|string|max:255',
            'author_main_designation' => 'nullable|string|max:255',
            'author_main_institute' => 'nullable|string|max:255',
            'author_main_email' => 'required|email|max:255',
            'author_main_mobile' => 'nullable|string|max:20',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'co_authors' => 'nullable|string',
            'status' => 'required|in:submitted,under_review,accepted,rejected,published'
        ]);

        try {
            $data = $request->all();
            
            // Handle file upload
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($submission->file_path) {
                    Storage::disk('public')->delete($submission->file_path);
                }
                
                $filePath = $request->file('file')->store('submissions', 'public');
                $data['file_path'] = $filePath;
            }

            // Handle co-authors JSON
            if ($request->filled('co_authors')) {
                try {
                    $data['co_authors'] = json_decode($request->co_authors, true);
                } catch (\Exception $e) {
                    // If JSON is invalid, keep the existing co_authors
                    unset($data['co_authors']);
                }
            }

            $submission->update($data);

            return redirect()->route('admin.submissions.index')->with('success', 'Submission updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating the submission.')
                ->withInput();
        }
    }

    public function destroy(PaperSubmission $submission)
    {
        try {
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $submission->delete();

            return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.submissions.index')->with('error', 'An error occurred while deleting the submission.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'research_area' => 'required|string|max:255',
            'author_main_name' => 'required|string|max:255',
            'author_main_designation' => 'nullable|string|max:255',
            'author_main_institute' => 'nullable|string|max:255',
            'author_main_email' => 'required|email|max:255',
            'author_main_mobile' => 'nullable|string|max:20',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'co_authors' => 'nullable|string',
            'file' => 'required|file|mimes:doc,docx|max:10240',
            'status' => 'required|in:submitted,under_review,accepted,rejected,published'
        ], [
            'file.mimes' => 'The file must be a Word document (doc, docx).',
            'file.max' => 'The file must not exceed 10MB.',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('submissions', 'public');
                $validated['file_path'] = $filePath;
            }

            // Handle co-authors JSON
            if ($request->filled('co_authors')) {
                try {
                    $validated['co_authors'] = json_decode($request->co_authors, true);
                } catch (\Exception $e) {
                    // If JSON is invalid, set to empty array
                    $validated['co_authors'] = [];
                }
            } else {
                $validated['co_authors'] = null;
            }

            // Create the submission
            $submission = PaperSubmission::create($validated);

            return redirect()->route('admin.submissions.index')
                ->with('success', 'Submission created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while creating the submission.')
                ->withInput();
        }
    }
}