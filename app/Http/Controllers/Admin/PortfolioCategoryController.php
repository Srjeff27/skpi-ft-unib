<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioCategoryController extends Controller
{
    public function index(): View
    {
        $categories = PortfolioCategory::orderBy('name')->paginate(20);
        return view('admin.portfolio_categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.portfolio_categories.form', ['category' => new PortfolioCategory()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
        ]);
        PortfolioCategory::create($data);
        return redirect()->route('admin.portfolio-categories.index')->with('status','Kategori ditambahkan');
    }

    public function edit(PortfolioCategory $portfolio_category): View
    {
        return view('admin.portfolio_categories.form', ['category' => $portfolio_category]);
    }

    public function update(Request $request, PortfolioCategory $portfolio_category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
        ]);
        $portfolio_category->update($data);
        return redirect()->route('admin.portfolio-categories.index')->with('status','Kategori diperbarui');
    }

    public function destroy(PortfolioCategory $portfolio_category): RedirectResponse
    {
        $portfolio_category->delete();
        return back()->with('status','Kategori dihapus');
    }
}
