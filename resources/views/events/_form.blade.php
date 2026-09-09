@csrf

<div class="grid gap-4 md:grid-cols-2">
    <label><span class="pp-label">Nome do evento</span><input class="pp-input" name="name" value="{{ old('name', $event->name) }}" required></label>
    <label><span class="pp-label">Cliente</span><input class="pp-input" name="client" value="{{ old('client', $event->client) }}"></label>
    <label><span class="pp-label">Data</span><input class="pp-input" type="date" name="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" required></label>
    <label><span class="pp-label">Horário do evento</span><input class="pp-input" type="time" name="event_time" value="{{ old('event_time', $event->event_time?->format('H:i')) }}"></label>
    <label><span class="pp-label">Horário de montagem</span><input class="pp-input" type="time" name="assembly_time" value="{{ old('assembly_time', $event->assembly_time?->format('H:i')) }}"></label>
    <label><span class="pp-label">Responsavel</span>
        <select class="pp-input" name="responsible_user_id">
            <option value="">Selecionar</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('responsible_user_id', $event->responsible_user_id) == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
    </label>
    <label><span class="pp-label">Local</span><input class="pp-input" name="location" value="{{ old('location', $event->location) }}"></label>
    <label><span class="pp-label">Cidade</span><input class="pp-input" name="city" value="{{ old('city', $event->city) }}"></label>
</div>

<div class="mt-5">
    <span class="pp-label">Categorias envolvidas</span>
    <div class="flex flex-wrap gap-2">
        @foreach ($categories as $category)
            <label class="rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-slate-700">
                <input class="mr-1" type="checkbox" name="category_tags[]" value="{{ $category->name }}" @checked(in_array($category->name, old('category_tags', $event->category_tags ?? [])))>
                {{ $category->name }}
            </label>
        @endforeach
    </div>
</div>

<label class="mt-5 block"><span class="pp-label">Observações gerais</span><textarea class="pp-input min-h-28" name="notes">{{ old('notes', $event->notes) }}</textarea></label>

@if ($errors->any())
    <div class="mt-4 rounded-xl bg-rose-50 p-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
@endif

<div class="mt-6 flex gap-3">
    <button class="pp-btn pp-btn-primary">Salvar</button>
    <a href="{{ route('events.index') }}" class="pp-btn pp-btn-muted">Cancelar</a>
</div>
