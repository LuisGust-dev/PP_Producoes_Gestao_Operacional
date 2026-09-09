<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventEquipmentRequest;
use App\Models\Equipment;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;

class EventEquipmentController extends Controller
{
    public function store(StoreEventEquipmentRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->equipmentItems()->create($request->validated() + ['required' => $request->boolean('required', true)]);

        $event->logs()->create([
            'user_id' => $request->user()->id,
            'action' => 'event.equipment.added',
            'description' => Equipment::find($request->integer('equipment_id'))?->name.' adicionado ao evento.',
        ]);

        return back()->with('status', 'Equipamento adicionado ao evento.');
    }
}
