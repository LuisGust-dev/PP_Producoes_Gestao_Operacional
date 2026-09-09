<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Equipment::class);

        $equipment = Equipment::query()
            ->with('category')
            ->when(request('category'), fn ($query, $category) => $query->where('category_id', $category))
            ->orderBy('name')
            ->paginate(16);

        return view('equipment.index', [
            'equipment' => $equipment,
            'categories' => Category::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Equipment::class);

        return view('equipment.create', [
            'equipment' => new Equipment(['unit' => 'unidades', 'status' => 'available', 'active' => true]),
            'categories' => Category::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        $equipment = Equipment::create($request->validated() + ['active' => $request->boolean('active', true)]);

        return redirect()->route('equipment.show', $equipment)->with('status', 'Equipamento criado.');
    }

    public function show(Equipment $equipment): View
    {
        $this->authorize('view', $equipment);

        $equipment->load('category');

        return view('equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment): View
    {
        $this->authorize('update', $equipment);

        return view('equipment.edit', [
            'equipment' => $equipment,
            'categories' => Category::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(StoreEquipmentRequest $request, Equipment $equipment): RedirectResponse
    {
        $equipment->update($request->validated() + ['active' => $request->boolean('active')]);

        return redirect()->route('equipment.show', $equipment)->with('status', 'Equipamento atualizado.');
    }

    public function destroy(Equipment $equipment): RedirectResponse
    {
        $this->authorize('delete', $equipment);

        $equipment->update(['active' => false]);

        return redirect()->route('equipment.index')->with('status', 'Equipamento desativado.');
    }
}
