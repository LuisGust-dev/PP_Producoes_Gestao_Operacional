@csrf

<div class="grid gap-4 md:grid-cols-2">
    <label><span class="pp-label">Nome</span><input class="pp-input" name="name" value="{{ old('name', $equipment->name) }}" required></label>
    <label><span class="pp-label">Categoria</span>
        <select class="pp-input" name="category_id" required>
            <option value="">Selecionar</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $equipment->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </label>
    <label><span class="pp-label">Quantidade total</span><input class="pp-input" type="number" min="0" name="total_quantity" value="{{ old('total_quantity', $equipment->total_quantity) }}" required></label>
    <label><span class="pp-label">Unidade</span><input class="pp-input" name="unit" value="{{ old('unit', $equipment->unit ?? 'unidades') }}" required></label>
    <label><span class="pp-label">Código interno</span><input class="pp-input" name="code" value="{{ old('code', $equipment->code) }}"></label>
    <label><span class="pp-label">Status</span><input class="pp-input" name="status" value="{{ old('status', $equipment->status ?? 'available') }}" required></label>
</div>

<label class="mt-5 block"><span class="pp-label">Descrição</span><textarea class="pp-input min-h-24" name="description">{{ old('description', $equipment->description) }}</textarea></label>
<label class="mt-5 block"><span class="pp-label">Observações</span><textarea class="pp-input min-h-24" name="notes">{{ old('notes', $equipment->notes) }}</textarea></label>

<label class="mt-5 inline-flex items-center gap-2 font-bold text-slate-700">
    <input type="checkbox" name="active" value="1" @checked(old('active', $equipment->active ?? true))>
    Ativo
</label>

@if ($errors->any())
    <div class="mt-4 rounded-xl bg-rose-50 p-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
@endif

<div class="mt-6 flex gap-3">
    <button class="pp-btn pp-btn-primary">Salvar</button>
    <a href="{{ route('equipment.index') }}" class="pp-btn pp-btn-muted">Cancelar</a>
</div>
