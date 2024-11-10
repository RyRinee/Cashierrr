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

        return redirect('menuList')->with('successcreate', 'Menu Baru Ditambahkan');
    }


    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('menu.editMenu', compact('menu'));
    }


    public function update(Request $request, Menu $menu)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Tentukan status berdasarkan stok
        $status = ($validatedData['stock'] > 0) ? 'tersedia' : 'habis';
        $input = $validatedData;
        $input['status'] = $status;

        // Perbarui gambar jika ada file baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) {
                unlink(public_path('storage/image/' . $menu->image));
            }
            // Simpan gambar baru
            $image = $request->file('image');
            $image_name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('storage/image'), $image_name);
            $input['image'] = $image_name;
        }

        // Update data menu di database
        $menu->update($input);

        return redirect()->route('menuList')->with('successupdate', 'Menu Berhasil Diperbarui');
    }


    public function destroy(Menu $menu)
    {
        // Hapus gambar dari direktori jika ada
        if ($menu->image) {
            unlink(public_path('storage/image/' . $menu->image));
        }

        // Hapus menu dari database
        $menu->delete();
        return redirect()->route('menuList')->with('successdelete', 'Menu Berhasil Dihapus');
    }
}
