<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('menu.menuList');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.addMenu');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:makanan,minuman',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Validasi gambar dengan tipe tertentu dan maksimum ukuran 2MB
            'status' => 'required|string|in:tersedia,habis',
        ]);

        $input = $validatedData;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . $image->getClientOriginalName();
            $request->image->move(public_path('storage/image'), $image_name);

            $input['image'] = $image_name;
        }

        Menu::create($input);

        return redirect('menus')->with('successcreate', 'Menu Baru Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
