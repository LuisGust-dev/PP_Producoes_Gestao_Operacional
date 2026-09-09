<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCustomItem;
use App\Models\EventEquipment;
use App\Services\ChecklistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function updateEquipment(Request $request, Event $event, EventEquipment $item, ChecklistService $service): RedirectResponse
    {
        $this->authorize('view', $event);
        abort_unless($item->event_id === $event->id, 404);

        $validated = $request->validate($this->quantityRules($item->required_quantity, $item->loaded_quantity));
        $service->updateQuantities($item->load('event', 'equipment'), $validated, $request->user());

        return back()->with('status', 'Equipamento atualizado.');
    }

    public function updateCustomItem(Request $request, Event $event, EventCustomItem $item, ChecklistService $service): RedirectResponse
    {
        $this->authorize('view', $event);
        abort_unless($item->event_id === $event->id, 404);

        $validated = $request->validate($this->quantityRules($item->required_quantity, $item->loaded_quantity));
        $service->updateQuantities($item->load('event'), $validated, $request->user());

        return back()->with('status', 'Item atualizado.');
    }

    public function release(Request $request, Event $event, ChecklistService $service): RedirectResponse
    {
        $this->authorize('update', $event);

        $service->release($event, $request->user());

        return back()->with('status', 'Evento liberado para saída.');
    }

    private function quantityRules(int $required, int $loaded): array
    {
        return [
            'separated_quantity' => ['sometimes', 'integer', 'min:0', 'max:'.$required],
            'loaded_quantity' => ['sometimes', 'integer', 'min:0', 'max:'.$required],
            'returned_quantity' => ['sometimes', 'integer', 'min:0', 'max:'.$loaded],
        ];
    }
}
