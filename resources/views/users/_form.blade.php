@csrf

<div class="grid gap-4 md:grid-cols-2">
    <label><span class="pp-label">Nome</span><input class="pp-input" name="name" value="{{ old('name', $user->name) }}" required></label>
    <label><span class="pp-label">Email</span><input class="pp-input" type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
    <label><span class="pp-label">Perfil</span>
        <select class="pp-input" name="role" required>
            @foreach ($roles as $role)
                <option value="{{ $role->value }}" @selected(old('role', $user->role?->value) === $role->value)>{{ $role->label() }}</option>
            @endforeach
        </select>
    </label>
    <label class="flex items-center gap-2 pt-7 font-bold text-slate-700">
        <input type="checkbox" name="active" value="1" @checked(old('active', $user->active ?? true))>
        Usuário ativo
    </label>
    <label><span class="pp-label">Senha {{ $user->exists ? '(opcional)' : '' }}</span><input class="pp-input" type="password" name="password" autocomplete="new-password" {{ $user->exists ? '' : 'required' }}></label>
    <label><span class="pp-label">Confirmar senha</span><input class="pp-input" type="password" name="password_confirmation" autocomplete="new-password" {{ $user->exists ? '' : 'required' }}></label>
</div>

@if ($errors->any())
    <div class="mt-4 rounded-xl bg-rose-50 p-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</div>
@endif

<div class="mt-6 flex gap-3">
    <button class="pp-btn pp-btn-primary">Salvar</button>
    <a href="{{ route('users.index') }}" class="pp-btn pp-btn-muted">Cancelar</a>
</div>
