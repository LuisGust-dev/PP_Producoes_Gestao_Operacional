<?php

namespace App\Models;

use App\Enums\EventStatus;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'client', 'event_date', 'event_time', 'assembly_time', 'location', 'city', 'responsible_user_id', 'status', 'category_tags', 'notes', 'released_by', 'released_at'])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'event_time' => 'datetime:H:i',
            'assembly_time' => 'datetime:H:i',
            'status' => EventStatus::class,
            'category_tags' => 'array',
            'released_at' => 'datetime',
        ];
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function releasedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_by');
    }

    public function equipmentItems(): HasMany
    {
        return $this->hasMany(EventEquipment::class);
    }

    public function customItems(): HasMany
    {
        return $this->hasMany(EventCustomItem::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(EventLog::class);
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(EquipmentOccurrence::class);
    }

    public function totalChecklistItems(): int
    {
        return $this->equipmentItems->count() + $this->customItems->count();
    }

    public function progressFor(string $field): int
    {
        $items = $this->equipmentItems->concat($this->customItems);
        $required = $items->sum('required_quantity');

        if ($required <= 0) {
            return 0;
        }

        return (int) round(($items->sum($field) / $required) * 100);
    }

    public function loadedRequiredItemsCount(): int
    {
        return $this->equipmentItems->where('required', true)->filter(fn ($item) => $item->loaded_quantity >= $item->required_quantity)->count()
            + $this->customItems->where('required', true)->filter(fn ($item) => $item->loaded_quantity >= $item->required_quantity)->count();
    }

    public function pendingRequiredItems()
    {
        return $this->equipmentItems->where('required', true)->filter(fn ($item) => $item->loaded_quantity < $item->required_quantity)
            ->concat($this->customItems->where('required', true)->filter(fn ($item) => $item->loaded_quantity < $item->required_quantity));
    }
}
