<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Category::class);

        return view('categories.index', [
            'categories' => Category::withCount('equipment')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Category::class);

        return view('categories.create', ['category' => new Category(['active' => true])]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated() + ['active' => $request->boolean('active', true)]);

        return redirect()->route('categories.index')->with('status', 'Categoria criada.');
    }

    public function show(Category $category): View
    {
        $this->authorize('view', $category);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated() + ['active' => $request->boolean('active')]);

        return redirect()->route('categories.index')->with('status', 'Categoria atualizada.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);

        $category->update(['active' => false]);

        return redirect()->route('categories.index')->with('status', 'Categoria desativada.');
    }
}
