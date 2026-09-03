<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class VisitorCounterController extends Controller
{
    public function edit()
    {
        $available = $this->counterAvailable();
        $counter = $available
            ? VisitorCounter::query()->find(1)
            : new VisitorCounter(['total_visits' => 0, 'today_visits' => 0]);

        return view('admin.visitor-counter.edit', compact('counter', 'available'));
    }

    public function update(Request $request)
    {
        if (! $this->counterAvailable()) {
            return back()->withErrors([
                'total_visits' => 'Visitor counter database fields are not available yet. Run the visitor counter migrations first.',
            ]);
        }

        $validated = $request->validate([
            'total_visits' => 'required|integer|min:0',
        ]);

        $counter = VisitorCounter::query()->find(1);

        if (! $counter) {
            return back()->withErrors([
                'total_visits' => 'Visitor counter record was not found.',
            ]);
        }

        $counter->update([
            'total_visits' => $validated['total_visits'],
        ]);

        return redirect()->route('admin.visitor-counter.edit')
            ->with('success', 'Total visitor count updated successfully.');
    }

    private function counterAvailable(): bool
    {
        return Schema::hasTable('visitor_counters')
            && Schema::hasColumn('visitor_counters', 'today_visits')
            && Schema::hasColumn('visitor_counters', 'visit_date');
    }
}
