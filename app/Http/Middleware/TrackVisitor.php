<?php

namespace App\Http\Middleware;

use App\Models\VisitorCounter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    private const SESSION_KEY = 'bjdd_visitor_counted';

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldCount($request) && Schema::hasTable('visitor_counters')) {
            $counter = VisitorCounter::query()->find(1);

            if (! $counter) {
                $counter = VisitorCounter::query()->create(['total_visits' => 0]);
            }

            $hasTodayColumns = Schema::hasColumn('visitor_counters', 'today_visits')
                && Schema::hasColumn('visitor_counters', 'visit_date');
            $today = now()->toDateString();
            $sessionKey = self::SESSION_KEY . '_' . $today;

            if ($hasTodayColumns && $counter->visit_date?->toDateString() !== $today) {
                $counter->update([
                    'today_visits' => 0,
                    'visit_date' => $today,
                ]);
            }

            if (! $request->hasSession() || ! $request->session()->has($sessionKey)) {
                if ($hasTodayColumns) {
                    $counter->increment('today_visits');
                }

                $counter->increment('total_visits');

                if ($request->hasSession()) {
                    $request->session()->put($sessionKey, true);
                }
            }

            $counter = $counter->fresh();
            View::share('visitorCount', (int) $counter->total_visits);
            View::share('todayVisitorCount', $hasTodayColumns
                ? (int) $counter->today_visits
                : (int) $counter->total_visits);
        }

        return $next($request);
    }

    private function shouldCount(Request $request): bool
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true) || $request->expectsJson()) {
            return false;
        }

        foreach (['admin', 'admin/*', 'publications/*', 'issues/*', 'storage/*', 'documents/*'] as $pattern) {
            if ($request->is($pattern)) {
                return false;
            }
        }

        return true;
    }
}
