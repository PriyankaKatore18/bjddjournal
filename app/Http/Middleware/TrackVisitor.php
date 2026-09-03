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

            if (! $request->hasSession() || ! $request->session()->has(self::SESSION_KEY)) {
                $counter->increment('total_visits');

                if ($request->hasSession()) {
                    $request->session()->put(self::SESSION_KEY, true);
                }
            }

            View::share('visitorCount', (int) $counter->fresh()->total_visits);
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
