<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $events = Event::query()
            ->with(['equipmentItems', 'customItems'])
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->limit(6)
            ->get();

        return view('dashboard', [
            'eventsToday' => Event::whereDate('event_date', now()->toDateString())->count(),
            'upcomingEvents' => Event::whereDate('event_date', '>', now()->toDateString())->count(),
            'pendingChecklists' => Event::whereIn('status', [EventStatus::Draft, EventStatus::Preparing, EventStatus::Loading])->count(),
            'readyEvents' => Event::where('status', EventStatus::Ready)->count(),
            'events' => $events,
        ]);
    }
}
