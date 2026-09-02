<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Initialize counts with zeros
        $counts = [
            'newSubmissions' => 0,
            'underReview' => 0,
            'accepted' => 0,
            'published' => 0
        ];

        // Check if paper_submissions table exists
        if (Schema::hasTable('paper_submissions')) {
            try {
                // Get counts from paper_submissions table
                // Map 'pending' status to 'underReview' counter
                $counts['newSubmissions'] = DB::table('paper_submissions')
                    ->where('status', 'submitted')
                    ->count();

                $counts['underReview'] = DB::table('paper_submissions')
                    ->where('status', 'pending') // Changed from 'under_review' to 'pending'
                    ->count();

                $counts['accepted'] = DB::table('paper_submissions')
                    ->where('status', 'accepted')
                    ->count();

                $counts['published'] = DB::table('paper_submissions')
                    ->where('status', 'published')
                    ->count();

                // Debug logging
                \Log::info('Paper Submissions Dashboard Counts:', $counts);
                
            } catch (\Exception $e) {
                \Log::error('Error fetching paper submission counts: ' . $e->getMessage());
            }
        } else {
            \Log::warning('Paper submissions table does not exist');
        }

        return view('admin.dashboard', $counts);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // validate email always
        $rules = [
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        // if password fields filled, validate them
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min:6|confirmed';
        }

        $request->validate($rules);

        // update email
        $user->email = $request->email;

        // check & update password
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}