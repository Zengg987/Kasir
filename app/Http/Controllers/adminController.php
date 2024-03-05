<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class adminController extends Controller
{
    public function index()
    {
        return Inertia::render('dashboard');
    }

    public function addUser()
    {
        return Inertia::render('addUser');
    }

    // Menampilkan, menambah, mengedit, dan menghapus pengguna
    public function getUser()
    {
        $data = User::latest()->get();
        return response()->json($data);
    }

    public function postUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'sometimes|required|min:12',  // Validasi password hanya saat menambah atau jika diisi
            'role' => 'required',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);  // Hash password jika diisi
        } else {
            unset($data['password']);  // Jaga password lama jika tidak diisi
        }
        
        if (!$request->filled('email')) { 
            unset($data['email']); // Jaga email lama jika tidak diisi
        }
        

        User::updateOrCreate(['id' => $request->id], $data);

        return back();
    }

    public function editUser($id)
    {
        $data = User::where('id', $id)->first();
        return response()->json($data);
    }

    public function hapusUser($id)
    {
        User::where('id', $id)->delete();
        return back();
    }
}
