<?php

namespace App\Models;

use Database\Factories\EventEquipmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['event_id', 'equipment_id', 'required_quantity', 'separated_quantity', 'loaded_quantity', 'returned_quantity', 'observation', 'required', 'last_updated_by'])]
class EventEquipment extends Model
{
    /** @use HasFactory<EventEquipmentFactory> */
    use HasFactory;

    protected $table = 'event_equipment';

    protected function casts(): array
    {
        return [
            'required' => 'boolean',
            'required_quantity' => 'integer',
            'separated_quantity' => 'integer',
            'loaded_quantity' => 'integer',
            'returned_quantity' => 'integer',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function lastUpdatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }
}
