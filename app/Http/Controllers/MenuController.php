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
        $menus = Menu::all();
        return view('menu.menuList', compact('menus'));
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
        dd($request->file('image'));
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);
    
        // Tentukan status berdasarkan stok
        $status = ($validatedData['stock'] > 0) ? 'tersedia' : 'habis';
    
        // Menyiapkan data input untuk disimpan
        $input = $validatedData;
        $input['status'] = $status; // Menetapkan status otomatis
    
        // Menyimpan gambar dengan Storage
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('storage/image'), $image_name);
            $input['image'] = $image_name;
        }
    
        // Menyimpan menu ke dalam database
        Menu::create($input);
    
        return redirect('addMenu')->with('successcreate', 'Menu Baru Ditambahkan');
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
