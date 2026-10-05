<?php

namespace Tests\Feature;

use App\Mail\PaperSubmissionAcknowledgement;
use App\Models\PaperSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PaperSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_submission_form_renders_the_final_specification_fields(): void
    {
        $this->get(route('submit.paper'))
            ->assertOk()
            ->assertSee('Upload Plagiarism Report')
            ->assertSee('Upload AI Content Detection Report')
            ->assertSee('originality_declaration')
            ->assertSee('final_confirmation')
            ->assertSee('submitBtn');
    }

    public function test_complete_submission_saves_files_generates_paper_id_and_sends_acknowledgement(): void
    {
        Storage::fake('public');
        Mail::fake();

        $token = (string) Str::uuid();
        $response = $this->withSession(['paper_verification_answer' => '11'])
            ->post(route('submit.paper.submit'), $this->validSubmission($token));

        $response->assertRedirect(route('submit.paper'))
            ->assertSessionHas('paper_id', 'BJDD-'.now()->format('Y').'-00001')
            ->assertSessionHas('email_sent', true);

        $submission = PaperSubmission::firstOrFail();

        $this->assertSame('BJDD-'.now()->format('Y').'-00001', $submission->paper_id);
        $this->assertSame('submitted', $submission->status);
        $this->assertTrue($submission->originality_declaration);
        $this->assertTrue($submission->authorship_consent);
        $this->assertTrue($submission->ethics_declaration);
        $this->assertTrue($submission->journal_policies);
        $this->assertTrue($submission->final_confirmation);
        $this->assertNotNull($submission->email_sent_at);

        Storage::disk('public')->assertExists($submission->file_path);
        Storage::disk('public')->assertExists($submission->plagiarism_report_path);
        Storage::disk('public')->assertExists($submission->ai_report_path);
        Mail::assertSent(PaperSubmissionAcknowledgement::class, function ($mail) use ($submission) {
            return $mail->hasTo($submission->author_main_email)
                && $mail->submission->paper_id === $submission->paper_id;
        });
    }

    public function test_duplicate_submission_token_does_not_create_a_second_record(): void
    {
        Storage::fake('public');
        Mail::fake();

        $token = (string) Str::uuid();
        $this->withSession(['paper_verification_answer' => '11'])
            ->post(route('submit.paper.submit'), $this->validSubmission($token));

        $paperId = PaperSubmission::firstOrFail()->paper_id;

        $this->withSession(['paper_verification_answer' => '11'])
            ->post(route('submit.paper.submit'), $this->validSubmission($token))
            ->assertRedirect(route('submit.paper'))
            ->assertSessionHas('paper_id', $paperId);

        $this->assertDatabaseCount('paper_submissions', 1);
        Mail::assertSent(PaperSubmissionAcknowledgement::class, 1);
    }

    public function test_optional_reports_can_be_omitted_but_declarations_are_required(): void
    {
        Storage::fake('public');

        $data = $this->validSubmission((string) Str::uuid());
        unset($data['plagiarism_report'], $data['originality_declaration']);

        $this->withSession(['paper_verification_answer' => '11'])
            ->post(route('submit.paper.submit'), $data)
            ->assertRedirect()
            ->assertSessionHasErrors(['originality_declaration'])
            ->assertSessionDoesntHaveErrors(['plagiarism_report']);

        $this->assertDatabaseCount('paper_submissions', 0);
    }

    public function test_submission_without_reports_is_accepted(): void
    {
        Storage::fake('public');

        $data = $this->validSubmission((string) Str::uuid());
        unset($data['plagiarism_report'], $data['ai_report']);

        $this->withSession(['paper_verification_answer' => '11'])
            ->post(route('submit.paper.submit'), $data)
            ->assertRedirect()
            ->assertSessionHas('paper_id');

        $submission = PaperSubmission::firstOrFail();
        $this->assertNull($submission->plagiarism_report_path);
        $this->assertNull($submission->ai_report_path);
    }

    private function validSubmission(string $token): array
    {
        return [
            'submission_token' => $token,
            'previous_paper_id' => 'BJDD-2025-00001',
            'title' => 'A Complete Manuscript Title',
            'paper_file' => UploadedFile::fake()->create('manuscript.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            'plagiarism_report' => UploadedFile::fake()->create('plagiarism.pdf', 100, 'application/pdf'),
            'ai_report' => UploadedFile::fake()->create('ai-report.pdf', 100, 'application/pdf'),
            'research_area' => 'Computer Science, IT & Artificial Intelligence',
            'author_main_name' => 'Main Author',
            'author_main_designation' => 'Assistant Professor',
            'author_main_institute' => 'BJDD University',
            'author_main_email' => 'author@example.com',
            'author_main_mobile' => '9876543210',
            'co_authors' => [
                [
                    'name' => 'Co Author',
                    'designation' => 'Researcher',
                    'institute' => 'BJDD Research Centre',
                    'email' => 'coauthor@example.com',
                ],
            ],
            'address_line1' => '1 Journal Road',
            'address_line2' => 'Research Block',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'country' => 'India',
            'pincode' => '110001',
            'originality_declaration' => 'on',
            'authorship_consent' => 'on',
            'ethics_declaration' => 'on',
            'journal_policies' => 'on',
            'final_confirmation' => 'on',
            'verification_answer' => '11',
        ];
    }
}
