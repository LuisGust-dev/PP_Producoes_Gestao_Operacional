<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        return view('users.index', [
            'users' => User::query()->orderByDesc('active')->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('users.create', [
            'user' => new User(['role' => UserRole::Team, 'active' => true]),
            'roles' => UserRole::cases(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated() + [
            'active' => $request->boolean('active', true),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')->with('status', 'Membro da equipe criado.');
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
            'roles' => UserRole::cases(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->safe()->except('password');
        $data['active'] = $request->boolean('active');

        if ($request->user()->is($user)) {
            $data['role'] = UserRole::Admin;
            $data['active'] = true;
        }

        if ($request->filled('password')) {
            $data['password'] = $request->string('password')->toString();
        }

        $user->update($data);

        return redirect()->route('users.index')->with('status', 'Usuário atualizado.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->update(['active' => false]);

        return redirect()->route('users.index')->with('status', 'Usuário desativado.');
    }
}
