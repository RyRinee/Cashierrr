<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MenuExport;
use Illuminate\Support\Facades\Log;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menambahkan filter pencarian jika ada input 'search'
        $menus = Menu::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('category', 'like', '%' . $request->search . '%');
        })->get();

        return view('menu.menuList', compact('menus'));
    }


    public function indexAdmin(Request $request)
    {
        // Menambahkan filter pencarian jika ada input 'search'
        $menus = Menu::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('category', 'like', '%' . $request->search . '%');
        })->get();

        return view('menu.menuListAdmin', compact('menus'));
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



    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('menu.editMenu', compact('menu'));
    }


    public function update(Request $request)
    {
        // Mengambil data stok yang dikirimkan dari form
        $stocks = $request->input('stocks');
    
        // Memperbarui stok untuk setiap menu
        foreach ($stocks as $menuId => $stock) {
            // Mencari menu berdasarkan ID
            $menu = Menu::find($menuId);
    
            if ($menu) {
                // Memperbarui stok
                $menu->stock = $stock;
                $menu->save();
            }
        }
    
        // Mengarahkan kembali dengan pesan sukses
        return redirect()->route('menuList')->with('successupdate', 'Stok menu berhasil diperbarui.');
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

    public function show()
    {
        $menus = Menu::all();
        return view('sales.order', compact('menus'));
    }

    public function export()
    {
        return Excel::download(new MenuExport, 'menu_data.xlsx');
    }
}
