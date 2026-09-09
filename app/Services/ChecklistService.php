<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\EventCustomItem;
use App\Models\EventEquipment;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ChecklistService
{
    public function updateQuantities(EventEquipment|EventCustomItem $item, array $quantities, User $user): void
    {
        $required = (int) $item->required_quantity;
        $separated = (int) ($quantities['separated_quantity'] ?? $item->separated_quantity);
        $loaded = (int) ($quantities['loaded_quantity'] ?? $item->loaded_quantity);
        $returned = (int) ($quantities['returned_quantity'] ?? $item->returned_quantity);

        if ($separated > $required || $loaded > $required || $returned > $loaded) {
            throw ValidationException::withMessages([
                'quantity' => 'As quantidades nao podem ultrapassar necessario, carregado ou retornado.',
            ]);
        }

        $item->forceFill([
            'separated_quantity' => $separated,
            'loaded_quantity' => $loaded,
            'returned_quantity' => $returned,
            'last_updated_by' => $user->id,
        ])->save();

        $item->event->logs()->create([
            'user_id' => $user->id,
            'action' => 'checklist.updated',
            'description' => $this->describeItem($item).' atualizado no checklist.',
        ]);
    }

    public function release(Event $event, User $user): void
    {
        $event->loadMissing(['equipmentItems.equipment', 'customItems']);
        $pending = $event->pendingRequiredItems();

        if ($pending->isNotEmpty()) {
            throw ValidationException::withMessages([
                'event' => 'Nao e possivel liberar o evento. Existem '.$pending->count().' itens obrigatorios pendentes.',
            ]);
        }

        $event->forceFill([
            'status' => EventStatus::Ready,
            'released_by' => $user->id,
            'released_at' => now(),
        ])->save();

        $event->logs()->create([
            'user_id' => $user->id,
            'action' => 'event.released',
            'description' => 'Evento liberado para saída.',
        ]);
    }

    private function describeItem(EventEquipment|EventCustomItem $item): string
    {
        return $item instanceof EventEquipment
            ? $item->equipment?->name ?? 'Equipamento'
            : $item->name;
    }
}
