<?php

namespace App\Http\Controllers;

use App\Mail\PaperSubmissionAcknowledgement;
use App\Models\PaperSubmission;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaperSubmissionController extends Controller
{
    private const STATUSES = [
        'submitted' => 'Submitted',
        'editorial_screening' => 'Editorial Screening',
        'revision_required' => 'Revision Required',
        'under_review' => 'Under Review',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
        'payment_pending' => 'Payment Pending',
        'published' => 'Published',
    ];

    // ---------- FRONTEND ----------
    public function showForm()
    {
        $firstNumber = random_int(1, 10);
        $secondNumber = random_int(1, 10);
        session(['paper_verification_answer' => (string) ($firstNumber + $secondNumber)]);

        return view('submit-paper', [
            'verificationQuestion' => $firstNumber.' + '.$secondNumber.' =',
        ]);
    }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'submission_token' => ['required', 'uuid'],
            'previous_paper_id' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'paper_file' => ['required', 'file', 'mimes:doc,docx', 'max:10240'],
            'plagiarism_report' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'ai_report' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'research_area' => ['required', 'string', 'max:255'],
            'author_main_name' => ['required', 'string', 'max:255'],
            'author_main_designation' => ['required', 'string', 'max:255'],
            'author_main_institute' => ['required', 'string', 'max:255'],
            'author_main_email' => ['required', 'email', 'max:255'],
            'author_main_mobile' => ['required', 'digits:10'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'pincode' => ['required', 'digits:6'],
            'co_authors' => ['nullable', 'array', 'max:3'],
            'co_authors.*.name' => ['nullable', 'string', 'max:255'],
            'co_authors.*.designation' => ['nullable', 'string', 'max:255'],
            'co_authors.*.institute' => ['nullable', 'string', 'max:255'],
            'co_authors.*.email' => ['nullable', 'email', 'max:255'],
            'originality_declaration' => ['accepted'],
            'authorship_consent' => ['accepted'],
            'ethics_declaration' => ['accepted'],
            'journal_policies' => ['accepted'],
            'final_confirmation' => ['accepted'],
            'verification_answer' => ['required', 'digits_between:1,2'],
        ], [
            'paper_file.required' => 'The manuscript file is required.',
            'paper_file.mimes' => 'The manuscript must be a DOC or DOCX file.',
            'paper_file.max' => 'The manuscript must not exceed 10 MB.',
            'plagiarism_report.required' => 'The plagiarism report is required.',
            'plagiarism_report.mimes' => 'The plagiarism report must be a PDF file.',
            'plagiarism_report.max' => 'The plagiarism report must not exceed 10 MB.',
            'ai_report.mimes' => 'The AI content detection report must be a PDF file.',
            'ai_report.max' => 'The AI content detection report must not exceed 10 MB.',
            'author_main_mobile.digits' => 'The main author mobile number must be exactly 10 digits.',
            'pincode.digits' => 'The pincode must be exactly 6 digits.',
            'author_main_email.email' => 'Please provide a valid email address.',
            'co_authors.*.email.email' => 'Please provide a valid email address for each co-author.',
            '*.accepted' => 'All declarations must be accepted before submitting.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $expectedAnswer = (string) session('paper_verification_answer', '');
            $providedAnswer = trim((string) $request->input('verification_answer'));

            if ($expectedAnswer === '' || ! hash_equals($expectedAnswer, $providedAnswer)) {
                $validator->errors()->add('verification_answer', 'The verification answer is incorrect. Please try again.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $submissionToken = $request->string('submission_token')->toString();
        $existingSubmission = PaperSubmission::where('submission_token', $submissionToken)->first();

        if ($existingSubmission) {
            return redirect()->route('submit.paper')
                ->with('success', 'This manuscript has already been submitted.')
                ->with('paper_id', $existingSubmission->paper_id)
                ->with('email_sent', (bool) $existingSubmission->email_sent_at);
        }

        $storedFiles = [];

        try {
            $storedFiles['file_path'] = $request->file('paper_file')->store('submissions', 'public');
            $storedFiles['plagiarism_report_path'] = $request->file('plagiarism_report')->store('submissions/reports', 'public');

            if ($request->hasFile('ai_report')) {
                $storedFiles['ai_report_path'] = $request->file('ai_report')->store('submissions/reports', 'public');
            }

            $submission = DB::transaction(function () use ($request, $submissionToken, $storedFiles) {
                $submission = new PaperSubmission();
                $submission->fill([
                    'previous_paper_id' => $request->input('previous_paper_id'),
                    'title' => $request->input('title'),
                    'file_path' => $storedFiles['file_path'],
                    'plagiarism_report_path' => $storedFiles['plagiarism_report_path'],
                    'ai_report_path' => $storedFiles['ai_report_path'] ?? null,
                    'research_area' => $request->input('research_area'),
                    'author_main_name' => $request->input('author_main_name'),
                    'author_main_designation' => $request->input('author_main_designation'),
                    'author_main_institute' => $request->input('author_main_institute'),
                    'author_main_email' => $request->input('author_main_email'),
                    'author_main_mobile' => $request->input('author_main_mobile'),
                    'co_authors' => $this->cleanCoAuthors($request->input('co_authors', [])),
                    'address_line1' => $request->input('address_line1'),
                    'address_line2' => $request->input('address_line2'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'country' => $request->input('country'),
                    'pincode' => $request->input('pincode'),
                    'originality_declaration' => true,
                    'authorship_consent' => true,
                    'ethics_declaration' => true,
                    'journal_policies' => true,
                    'final_confirmation' => true,
                    'submission_token' => $submissionToken,
                    'status' => 'submitted',
                    'submitted_at' => now(),
                ]);
                $submission->save();

                $submission->paper_id = 'BJDD-'.now()->format('Y').'-'.str_pad((string) $submission->id, 5, '0', STR_PAD_LEFT);
                $submission->save();

                return $submission;
            });
        } catch (QueryException $exception) {
            $this->deleteStoredFiles($storedFiles);
            $existingSubmission = PaperSubmission::where('submission_token', $submissionToken)->first();

            if ($existingSubmission) {
                return redirect()->route('submit.paper')
                    ->with('success', 'This manuscript has already been submitted.')
                    ->with('paper_id', $existingSubmission->paper_id)
                    ->with('email_sent', (bool) $existingSubmission->email_sent_at);
            }

            Log::error('Paper submission database error', ['exception' => $exception]);

            return redirect()->back()->with('error', 'The submission could not be saved. Please try again.')->withInput();
        } catch (\Throwable $exception) {
            $this->deleteStoredFiles($storedFiles);
            Log::error('Paper submission failed', ['exception' => $exception]);

            return redirect()->back()->with('error', 'An error occurred while submitting your paper. Please try again.')->withInput();
        }

        session()->forget('paper_verification_answer');
        $emailSent = $this->sendAcknowledgement($submission);

        return redirect()->route('submit.paper')
            ->with('success', 'Your manuscript has been submitted successfully.')
            ->with('paper_id', $submission->paper_id)
            ->with('email_sent', $emailSent);
    }

    // ---------- ADMIN ----------
    public function index()
    {
        $submissions = PaperSubmission::latest('submitted_at')->latest()->paginate(10);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function create()
    {
        return view('admin.submissions.create', ['statuses' => self::STATUSES]);
    }

    public function edit(PaperSubmission $submission)
    {
        return view('admin.submissions.edit', [
            'submission' => $submission,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, PaperSubmission $submission)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'previous_paper_id' => ['nullable', 'string', 'max:100'],
            'research_area' => ['required', 'string', 'max:255'],
            'author_main_name' => ['required', 'string', 'max:255'],
            'author_main_designation' => ['nullable', 'string', 'max:255'],
            'author_main_institute' => ['nullable', 'string', 'max:255'],
            'author_main_email' => ['required', 'email', 'max:255'],
            'author_main_mobile' => ['nullable', 'digits:10'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'digits:6'],
            'co_authors' => ['nullable', 'array', 'max:3'],
            'co_authors.*.name' => ['nullable', 'string', 'max:255'],
            'co_authors.*.designation' => ['nullable', 'string', 'max:255'],
            'co_authors.*.institute' => ['nullable', 'string', 'max:255'],
            'co_authors.*.email' => ['nullable', 'email', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:doc,docx', 'max:10240'],
            'plagiarism_report' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'ai_report' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'status' => ['required', 'in:'.implode(',', array_keys(self::STATUSES))],
        ]);

        $data = collect($validated)->except(['file', 'plagiarism_report', 'ai_report'])->all();
        $storedFiles = [];

        $data['co_authors'] = $this->cleanCoAuthors($data['co_authors'] ?? []);

        try {
            foreach ([
                'file' => 'file_path',
                'plagiarism_report' => 'plagiarism_report_path',
                'ai_report' => 'ai_report_path',
            ] as $input => $column) {
                if ($request->hasFile($input)) {
                    if ($submission->{$column}) {
                        Storage::disk('public')->delete($submission->{$column});
                    }

                    $directory = $input === 'file' ? 'submissions' : 'submissions/reports';
                    $storedFiles[$column] = $request->file($input)->store($directory, 'public');
                    $data[$column] = $storedFiles[$column];
                }
            }

            if (! $submission->paper_id) {
                $year = optional($submission->submitted_at ?? $submission->created_at)->format('Y') ?: now()->format('Y');
                $data['paper_id'] = 'BJDD-'.$year.'-'.str_pad((string) $submission->id, 5, '0', STR_PAD_LEFT);
            }

            if (! $submission->submitted_at) {
                $data['submitted_at'] = $submission->created_at ?? now();
            }

            $submission->update($data);

            return redirect()->route('admin.submissions.index')->with('success', 'Submission updated successfully.');
        } catch (\Throwable $exception) {
            $this->deleteStoredFiles($storedFiles);
            Log::error('Admin submission update failed', ['exception' => $exception]);

            return redirect()->back()->with('error', 'The submission could not be updated.')->withInput();
        }
    }

    public function destroy(PaperSubmission $submission)
    {
        try {
            $this->deleteStoredFiles([
                'file_path' => $submission->file_path,
                'plagiarism_report_path' => $submission->plagiarism_report_path,
                'ai_report_path' => $submission->ai_report_path,
            ]);
            $submission->delete();

            return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted successfully.');
        } catch (\Throwable $exception) {
            Log::error('Submission delete failed', ['exception' => $exception]);

            return redirect()->route('admin.submissions.index')->with('error', 'The submission could not be deleted.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'previous_paper_id' => ['nullable', 'string', 'max:100'],
            'research_area' => ['required', 'string', 'max:255'],
            'author_main_name' => ['required', 'string', 'max:255'],
            'author_main_designation' => ['nullable', 'string', 'max:255'],
            'author_main_institute' => ['nullable', 'string', 'max:255'],
            'author_main_email' => ['required', 'email', 'max:255'],
            'author_main_mobile' => ['nullable', 'digits:10'],
            'address_line1' => ['nullable', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'digits:6'],
            'co_authors' => ['nullable', 'array', 'max:3'],
            'co_authors.*.name' => ['nullable', 'string', 'max:255'],
            'co_authors.*.designation' => ['nullable', 'string', 'max:255'],
            'co_authors.*.institute' => ['nullable', 'string', 'max:255'],
            'co_authors.*.email' => ['nullable', 'email', 'max:255'],
            'file' => ['required', 'file', 'mimes:doc,docx', 'max:10240'],
            'plagiarism_report' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'ai_report' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'status' => ['required', 'in:'.implode(',', array_keys(self::STATUSES))],
        ]);

        $storedFiles = [];

        try {
            $storedFiles['file_path'] = $request->file('file')->store('submissions', 'public');
            if ($request->hasFile('plagiarism_report')) {
                $storedFiles['plagiarism_report_path'] = $request->file('plagiarism_report')->store('submissions/reports', 'public');
            }
            if ($request->hasFile('ai_report')) {
                $storedFiles['ai_report_path'] = $request->file('ai_report')->store('submissions/reports', 'public');
            }

            $data = collect($validated)->except(['file', 'plagiarism_report', 'ai_report'])->all();
            $data['co_authors'] = $this->cleanCoAuthors($data['co_authors'] ?? []);
            $data['file_path'] = $storedFiles['file_path'];
            $data['plagiarism_report_path'] = $storedFiles['plagiarism_report_path'] ?? null;
            $data['ai_report_path'] = $storedFiles['ai_report_path'] ?? null;
            $data['submitted_at'] = now();
            $data['submission_token'] = (string) Str::uuid();
            $data['originality_declaration'] = true;
            $data['authorship_consent'] = true;
            $data['ethics_declaration'] = true;
            $data['journal_policies'] = true;
            $data['final_confirmation'] = true;

            $submission = PaperSubmission::create($data);
            $submission->update([
                'paper_id' => 'BJDD-'.now()->format('Y').'-'.str_pad((string) $submission->id, 5, '0', STR_PAD_LEFT),
            ]);

            $this->sendAcknowledgement($submission);

            return redirect()->route('admin.submissions.index')->with('success', 'Submission created successfully.');
        } catch (\Throwable $exception) {
            $this->deleteStoredFiles($storedFiles);
            Log::error('Admin submission creation failed', ['exception' => $exception]);

            return redirect()->back()->with('error', 'The submission could not be created.')->withInput();
        }
    }

    public function downloadFile(PaperSubmission $submission, string $type)
    {
        $files = [
            'manuscript' => [$submission->file_path, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'plagiarism-report' => [$submission->plagiarism_report_path, 'application/pdf'],
            'ai-report' => [$submission->ai_report_path, 'application/pdf'],
        ];

        abort_unless(isset($files[$type]) && $files[$type][0], 404);

        [$path, $contentType] = $files[$type];
        abort_unless(Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->download($path, basename($path), ['Content-Type' => $contentType]);
    }

    public function retryAcknowledgement(PaperSubmission $submission)
    {
        $sent = $this->sendAcknowledgement($submission);

        return redirect()->back()->with(
            $sent ? 'success' : 'error',
            $sent ? 'Acknowledgement email sent successfully.' : 'Acknowledgement email could not be sent. Check the mail settings and logs.'
        );
    }

    private function sendAcknowledgement(PaperSubmission $submission): bool
    {
        try {
            Mail::to($submission->author_main_email)->send(new PaperSubmissionAcknowledgement($submission));
            $submission->forceFill([
                'email_sent_at' => now(),
                'email_error' => null,
            ])->save();

            return true;
        } catch (\Throwable $exception) {
            $submission->forceFill([
                'email_error' => Str::limit($exception->getMessage(), 2000),
            ])->save();
            Log::error('Paper acknowledgement email failed', [
                'submission_id' => $submission->id,
                'paper_id' => $submission->paper_id,
                'exception' => $exception,
            ]);

            return false;
        }
    }

    private function cleanCoAuthors(array $coAuthors): ?array
    {
        $cleaned = collect($coAuthors)->map(function (array $author) {
            return [
                'name' => trim((string) ($author['name'] ?? '')),
                'designation' => trim((string) ($author['designation'] ?? '')),
                'institute' => trim((string) ($author['institute'] ?? '')),
                'email' => trim((string) ($author['email'] ?? '')),
            ];
        })->filter(fn (array $author) => collect($author)->contains(fn ($value) => $value !== ''))->values()->all();

        return $cleaned ?: null;
    }

    private function deleteStoredFiles(array $files): void
    {
        foreach ($files as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
