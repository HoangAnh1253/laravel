<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(5);
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
    public function store()
    {
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
    public function update()
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy()
    {
        //

    }

    public function disable()
    {
    }
}