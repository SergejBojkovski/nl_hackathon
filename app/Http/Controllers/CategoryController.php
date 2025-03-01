<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::with('courses')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display a specific category.
     */
    public function show($id)
    {
        $category = Category::with('courses')->findOrFail($id);
        #ako trbe da se smeni view ovde se menja za koja strana treba da ide
        return view('categories.show', compact('category'));
    }
}
