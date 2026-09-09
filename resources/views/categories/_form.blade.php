@csrf

<label><span class="pp-label">Nome</span><input class="pp-input" name="name" value="{{ old('name', $category->name) }}" required></label>
<label class="mt-4 block"><span class="pp-label">Ícone</span><input class="pp-input" name="icon" value="{{ old('icon', $category->icon) }}"></label>
<label class="mt-5 inline-flex items-center gap-2 font-bold text-slate-700">
    <input type="checkbox" name="active" value="1" @checked(old('active', $category->active ?? true))>
    Ativa
</label>

@if ($errors->any())
    <div class="mt-4 rounded-xl bg-rose-50 p-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
@endif

<div class="mt-6 flex gap-3">
    <button class="pp-btn pp-btn-primary">Salvar</button>
    <a href="{{ route('categories.index') }}" class="pp-btn pp-btn-muted">Cancelar</a>
</div>
