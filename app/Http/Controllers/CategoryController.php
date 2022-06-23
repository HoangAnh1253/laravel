<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Service\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories =  $this->categoryService->getAllCategoryPaginate(5);
        return view('pages.category')->with(["categories" => $categories]);
    }

    /**
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $this->categoryService->create($request);
        return redirect()->route('category');
    }

    /**
     * Display the specified resource.
     *
     */
    public function show()
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Category $category)
    {
        $updated = $this->categoryService->update($request, $category);
        return new CategoryResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy()
    {
        //

    }

    public function disable(Category $category)
    {
        $deleted = $this->categoryService->disable($category);
        if (!$deleted)
            return new \Exception("loi r cha");
        return redirect()->route('category');
    }
}