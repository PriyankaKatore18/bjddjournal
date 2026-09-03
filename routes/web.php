<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaperSubmissionController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\ArticlesController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\ReviewerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Frontend\CurrentIssueController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\Admin\JournalTeamController;
use App\Http\Controllers\Admin\IndexPartnerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\VisitorCounterController;
use App\Models\JournalTeamMember;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

// ---------------- Front-end routes ----------------
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/authors', function () {
    return view('authors');
})->name('authors');


Route::get('/current-issue', [CurrentIssueController::class, 'index'])->name('current-issue');

Route::get('/issues/{issue}/download', [IssueController::class, 'downloadPdf'])->name('issues.download');

Route::get('/archive', [PublicationController::class, 'index'])->name('archive');
Route::get('/archive/volume/{volume}/issue/{issue}', [PublicationController::class, 'issueDetails'])->name('archive.issue');
Route::get('/article/{publicationKey}', [PublicationController::class, 'articleDetails'])->name('article.details');

Route::get('/publications/{publication}/view-pdf', [PublicationController::class, 'viewPdf'])
    ->name('publications.viewPdf');

Route::get('/editors-reviewers', function () {
    $chiefEditors = JournalTeamMember::where('type', 'chief_editor')
        ->where('is_active', true)
        ->orderBy('order', 'asc')
        ->get();

    $editors = JournalTeamMember::where('type', 'editor')
        ->where('is_active', true)
        ->orderBy('order', 'asc')
        ->get();

    $reviewers = JournalTeamMember::where('type', 'reviewer')
        ->where('is_active', true)
        ->orderBy('order', 'asc')
        ->get();

    return view('editors-reviewers', compact('chiefEditors', 'editors', 'reviewers'));
})->name('editors-reviewers');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::view('/about-journal', 'about-journal')->name('about-journal');
Route::view('/call-for-papers', 'call-for-papers')->name('call-for-papers');
Route::view('/policy', 'policy')->name('policy');


Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');


Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/submit-paper', [PaperSubmissionController::class, 'showForm'])->name('submit.paper');
Route::post('/submit-paper', [PaperSubmissionController::class, 'submitForm'])->name('submit.paper.submit');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Visitor counter
        Route::get('/visitor-counter', [VisitorCounterController::class, 'edit'])->name('visitor-counter.edit');
        Route::put('/visitor-counter', [VisitorCounterController::class, 'update'])->name('visitor-counter.update');

        // Logout
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

        Route::get('/current-issue', [App\Http\Controllers\Admin\CurrentIssueController::class, 'edit'])->name('current-issue.edit');
        Route::put('/current-issue', [App\Http\Controllers\Admin\CurrentIssueController::class, 'update'])->name('current-issue.update');

        Route::get('/submissions', [PaperSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/create', [PaperSubmissionController::class, 'create'])->name('submissions.create');
        Route::post('/submissions', [PaperSubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/submissions/{submission}/edit', [PaperSubmissionController::class, 'edit'])->name('submissions.edit');
        Route::put('/submissions/{submission}', [PaperSubmissionController::class, 'update'])->name('submissions.update');
        Route::delete('/submissions/{submission}', [PaperSubmissionController::class, 'destroy'])->name('submissions.destroy');

        // Authors
        Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
        Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
        Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
        Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
        Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
        Route::put('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

        // Articles
        Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');
        Route::get('/articles/create', [ArticlesController::class, 'create'])->name('articles.create');
        Route::post('/articles', [ArticlesController::class, 'store'])->name('articles.store');
        Route::get('/articles/{article}', [ArticlesController::class, 'show'])->name('articles.show');
        Route::get('/articles/{article}/edit', [ArticlesController::class, 'edit'])->name('articles.edit');
        Route::put('/articles/{article}', [ArticlesController::class, 'update'])->name('articles.update');
        Route::delete('/articles/{article}', [ArticlesController::class, 'destroy'])->name('articles.destroy');

        // Issues
        Route::get('/issues', [IssueController::class, 'index'])->name('issues.index');
        Route::get('/issues/create', [IssueController::class, 'create'])->name('issues.create');
        Route::post('/issues', [IssueController::class, 'store'])->name('issues.store');
        Route::get('/issues/{issue}', [IssueController::class, 'show'])->name('issues.show');
        Route::get('/issues/{issue}/edit', [IssueController::class, 'edit'])->name('issues.edit');
        Route::put('/issues/{issue}', [IssueController::class, 'update'])->name('issues.update');
        Route::delete('/issues/{issue}', [IssueController::class, 'destroy'])->name('issues.destroy');

        // Reviewers
        Route::get('/reviewers', [ReviewerController::class, 'index'])->name('reviewers.index');
        Route::get('/reviewers/create', [ReviewerController::class, 'create'])->name('reviewers.create');
        Route::post('/reviewers', [ReviewerController::class, 'store'])->name('reviewers.store');
        Route::get('/reviewers/{reviewer}', [ReviewerController::class, 'show'])->name('reviewers.show');
        Route::get('/reviewers/{reviewer}/edit', [ReviewerController::class, 'edit'])->name('reviewers.edit');
        Route::put('/reviewers/{reviewer}', [ReviewerController::class, 'update'])->name('reviewers.update');
        Route::delete('/reviewers/{reviewer}', [ReviewerController::class, 'destroy'])->name('reviewers.destroy');

        // Contact Submissions
        Route::get('/contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
        Route::get('/contact-submissions/{id}', [ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
        Route::delete('/contact-submissions/{id}', [ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');


        Route::get('publications', [PublicationController::class, 'adminIndex'])->name('publications.index');

        Route::get('publications/create', [PublicationController::class, 'create'])->name('publications.create');
        Route::post('publications', [PublicationController::class, 'store'])->name('publications.store');
        Route::get('publications/{publication}/edit', [PublicationController::class, 'edit'])->name('publications.edit');
        Route::put('publications/{publication}', [PublicationController::class, 'update'])->name('publications.update');
        Route::delete('publications/{publication}', [PublicationController::class, 'destroy'])->name('publications.destroy');

        Route::get('publications/{publication}/admin-view-pdf', [PublicationController::class, 'viewPdf'])
            ->name('publications.adminViewPdf');

        Route::get('publications/{publication}/view-pdf', [PublicationController::class, 'viewPdf'])
            ->name('publications.viewPdf');

        Route::prefix('index-partners')->name('index-partners.')->group(function () {

            Route::get('/', [IndexPartnerController::class, 'index'])->name('index');
            Route::get('/create', [IndexPartnerController::class, 'create'])->name('create');
            Route::post('/store', [IndexPartnerController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [IndexPartnerController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [IndexPartnerController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [IndexPartnerController::class, 'destroy'])->name('delete');
        });

        Route::prefix('blogs')->name('blogs.')->group(function () {

            Route::get('/', [BlogController::class, 'index'])->name('index');
            Route::get('/create', [BlogController::class, 'create'])->name('create');
            Route::post('/store', [BlogController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [BlogController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [BlogController::class, 'destroy'])->name('destroy');
        });

        Route::resource('journal-team', JournalTeamController::class);

        Route::post('profile/update', [DashboardController::class, 'updateProfile']);
    });
});


Route::get('publications/{publication}/download', [PublicationController::class, 'trackDownloadAndDownload'])
    ->name('publications.download');

Route::get('/issues/{issue}/view-pdf', [App\Http\Controllers\Frontend\CurrentIssueController::class, 'viewPdf'])
    ->name('issues.viewPdf');

Route::get('/storage/certificates/{filename}', function ($filename) {
    $path = storage_path('app/public/certificates/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('certificate.view');

Route::get('/documents/{filename}', function ($filename) {
    $path = storage_path('app/public/submissions/' . $filename);

    if (!file_exists($path)) {
        abort(404, "File not found: " . $filename);
    }

    return response()->file($path, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ]);
})->name('documents.view');

Route::get('/storage/journal-team/photos/{filename}', function ($filename) {
    $path = storage_path('app/public/journal-team/photos/' . $filename);

    if (!File::exists($path)) {
        abort(404, "File not found: " . $filename);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)
        ->header('Content-Type', $type)
        ->header('Cache-Control', 'public, max-age=31536000');
})->name('journal-team.photos');
