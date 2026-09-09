<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Http\Requests\StoreEventRequest;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Event::class);

        $events = Event::query()
            ->with(['equipmentItems', 'customItems', 'responsible'])
            ->latest('event_date')
            ->paginate(12);

        return view('events.index', [
            'events' => $events,
            'pageTitle' => 'Eventos',
            'pageSubtitle' => 'Agenda operacional',
            'emptyTitle' => 'Nenhum evento cadastrado.',
            'showCreateButton' => true,
        ]);
    }

    public function history(): View
    {
        $this->authorize('viewAny', Event::class);

        $events = Event::query()
            ->with(['equipmentItems', 'customItems', 'responsible'])
            ->whereIn('status', [EventStatus::Finished, EventStatus::Cancelled])
            ->latest('event_date')
            ->paginate(12);

        return view('events.index', [
            'events' => $events,
            'pageTitle' => 'Histórico',
            'pageSubtitle' => 'Eventos finalizados e cancelados',
            'emptyTitle' => 'Nenhum evento no histórico.',
            'showCreateButton' => false,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Event::class);

        return view('events.create', [
            'event' => new Event(['status' => EventStatus::Draft]),
            'categories' => Category::where('active', true)->orderBy('name')->get(),
            'users' => User::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = Event::create($request->validated() + ['status' => EventStatus::Preparing]);

        $event->logs()->create([
            'user_id' => $request->user()->id,
            'action' => 'event.created',
            'description' => 'Evento cadastrado.',
        ]);

        return redirect()->route('events.show', $event)->with('status', 'Evento criado.');
    }

    public function show(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load(['equipmentItems.equipment.category', 'customItems', 'logs.user', 'responsible', 'releasedBy']);

        return view('events.show', [
            'event' => $event,
            'equipment' => Equipment::with('category')->where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        return view('events.edit', [
            'event' => $event,
            'categories' => Category::where('active', true)->orderBy('name')->get(),
            'users' => User::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(StoreEventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->validated());

        $event->logs()->create([
            'user_id' => $request->user()->id,
            'action' => 'event.updated',
            'description' => 'Dados do evento atualizados.',
        ]);

        return redirect()->route('events.show', $event)->with('status', 'Evento atualizado.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->update(['status' => EventStatus::Cancelled]);

        return redirect()->route('events.index')->with('status', 'Evento cancelado.');
    }
}
