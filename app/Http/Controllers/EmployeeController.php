<?php

namespace App\Http\Controllers;
use App\Models\User; // Pastikan ini memang model yang ingin digunakan untuk Employee
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::all(); // Mengambil semua data karyawan
        return view('employee.listEmployee', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.addEmployee'); // Menampilkan form tambah karyawan
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'email' => 'required|email|max:255',
            'notelp' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Menyiapkan data input
        $input = $validatedData;

        // Menyimpan gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('storage/image'), $image_name);
            $input['image'] = $image_name;
        }

        // Menyimpan karyawan ke dalam database
        User::create($input);

        return redirect()->route('employeeList')->with('successcreate', 'Karyawan Baru Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('employee.editEmployee', compact('employee')); // Menampilkan form edit karyawan
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'email' => 'required|email|max:255',
            'notelp' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Menyiapkan data input
        $input = $validatedData;

        // Hapus gambar lama jika ada dan simpan gambar baru
        if ($request->hasFile('image')) {
            if ($employee->image) {
                unlink(public_path('storage/image/' . $employee->image));
            }
            $image = $request->file('image');
            $image_name = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('storage/image'), $image_name);
            $input['image'] = $image_name;
        }

        // Update data karyawan di database
        $employee->update($input);

        return redirect()->route('employeeList')->with('successupdate', 'Karyawan Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = User::findOrFail($id);

        // Hapus gambar dari direktori jika ada
        if ($employee->image) {
            unlink(public_path('storage/image/' . $employee->image));
        }

        // Hapus karyawan dari database
        $employee->delete();

        return redirect()->route('employeeList')->with('successdelete', 'Karyawan Berhasil Dihapus');
    }
}
