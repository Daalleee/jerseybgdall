<?php

namespace App\Http\Controllers;

use App\Models\Jersey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JerseyController extends Controller
{
    /**
     * Tampilkan daftar jersey untuk pelanggan
     */
    public function availableJerseys(Request $request)
    {
        // Hanya menampilkan jersey sistem yang aktif
        $query = Jersey::aktif()->with('user')->where('type', 'sistem');
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $jerseys = $query->paginate(9);
        
        return view('jerseys.available', compact('jerseys'));
    }

    /**
     * Tampilkan form jual jersey untuk pelanggan
     */
    public function showSellForm()
    {
        return view('jerseys.sell_form');
    }

    /**
     * Proses penjualan jersey oleh pelanggan
     */
    public function sellJersey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'size' => 'required|in:S,M,L,XL',
            'condition' => 'required|in:baru,bekas',
            'address' => 'required|string|max:500',
            'phone_number' => 'required|string|max:15',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('jerseys', 'public');
        }

        // Simpan foto tambahan dalam array
        $additionalPhotos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPathAdditional = $photo->store('jerseys', 'public');
                $additionalPhotos[] = $photoPathAdditional;
            }
        }

        $jersey = Jersey::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'size' => $request->size,
            'sizes' => json_encode([$request->size]), // Simpan ukuran yang dipilih sebagai array
            'condition' => $request->condition,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'status' => 'pending_review',
            'type' => 'pelanggan',
            'user_id' => Auth::id(),
            'photo' => $photoPath,
            'additional_photos' => $additionalPhotos, // Simpan foto tambahan sebagai array
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Jersey berhasil diajukan untuk ditinjau oleh admin.');
    }

    /**
     * Daftar jersey untuk admin
     */
    public function adminIndex(Request $request)
    {
        // Tampilkan semua jersey (sistem dan pelanggan) untuk admin
        $query = Jersey::with('user');
        
        // Filter berdasarkan tipe
        if ($request->has('type')) {
            switch ($request->type) {
                case 'sistem':
                    $query->where('type', 'sistem');
                    break;
                case 'pelanggan':
                    $query->where('type', 'pelanggan');
                    break;
                case 'review':
                    $query->where('type', 'pelanggan')->where('status', 'pending_review');
                    break;
                case 'all':
                default:
                    // Tampilkan semua
                    break;
            }
        }
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Urutkan berdasarkan tipe dan status
        $jerseys = $query->orderBy('type')->orderByRaw("FIELD(status, 'pending_review', 'aktif', 'ditolak')")->paginate(10);
        
        return view('admin.jerseys', compact('jerseys'));
    }
    
    /**
     * Daftar jersey sistem untuk admin
     */
    public function systemJerseys(Request $request)
    {
        // Tampilkan hanya jersey sistem untuk admin
        $query = Jersey::with('user')
                  ->where('type', 'sistem');
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Urutkan berdasarkan status
        $jerseys = $query->orderByRaw("FIELD(status, 'pending_review', 'aktif', 'ditolak')")->paginate(10);
        
        return view('admin.system_jerseys.index', compact('jerseys'));
    }

    /**
     * Tampilkan form create jersey untuk admin
     */
    public function adminCreate()
    {
        return view('admin.jersey_form');
    }

    /**
     * Simpan jersey baru untuk admin
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sizes' => 'required|array',
            'sizes.*' => 'in:S,M,L,XL',
            'condition' => 'required|in:baru,bekas',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('jerseys', 'public');
        }

        Jersey::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'size' => $request->sizes[0], // Simpan ukuran pertama sebagai ukuran utama
            'sizes' => $request->sizes, // Simpan semua ukuran yang tersedia
            'condition' => $request->condition,
            'type' => 'sistem',
            'status' => 'aktif',
            'photo' => $photoPath,
            'address' => 'Sistem',
            'phone_number' => 'Sistem',
            'user_id' => null,
        ]);

        return redirect()->route('admin.jerseys.index')->with('success', 'Jersey berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit jersey untuk admin
     */
    public function adminEdit(Jersey $jersey)
    {
        return view('admin.jersey_form', compact('jersey'));
    }

    /**
     * Update jersey untuk admin
     */
    public function adminUpdate(Request $request, Jersey $jersey)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sizes' => 'required|array',
            'sizes.*' => 'in:S,M,L,XL',
            'condition' => 'required|in:baru,bekas',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $jersey->photo;
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($jersey->photo) {
                Storage::disk('public')->delete($jersey->photo);
            }
            
            $photoPath = $request->file('photo')->store('jerseys', 'public');
        }

        $jersey->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'size' => $request->sizes[0], // Simpan ukuran pertama sebagai ukuran utama
            'sizes' => $request->sizes, // Simpan semua ukuran yang tersedia
            'condition' => $request->condition,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.jerseys.index')->with('success', 'Jersey berhasil diperbarui.');
    }

    /**
     * Hapus jersey untuk admin
     */
    public function adminDestroy(Jersey $jersey)
    {
        // Simpan informasi untuk redirect
        $currentPage = request('page', 1);
        $currentType = request('type', 'all');
        $currentSearch = request('search', '');
        
        // Hapus foto jika ada
        if ($jersey->photo) {
            Storage::disk('public')->delete($jersey->photo);
        }
        
        $jersey->delete();

        // Redirect kembali ke halaman yang sama dengan parameter yang sama
        $redirectUrl = route('admin.jerseys.index', [
            'page' => $currentPage,
            'type' => $currentType,
            'search' => $currentSearch,
        ]);
        
        return redirect($redirectUrl)->with('success', 'Jersey berhasil dihapus.');
    }

    /**
     * Setujui jersey dari pelanggan
     */
    public function approveJersey(Jersey $jersey)
    {
        // Simpan informasi untuk redirect
        $currentPage = request('page', 1);
        $currentType = request('type', 'all');
        $currentSearch = request('search', '');
        
        $jersey->update([
            'status' => 'aktif'
        ]);

        // Redirect kembali ke halaman yang sama dengan parameter yang sama
        $redirectUrl = route('admin.jerseys.index', [
            'page' => $currentPage,
            'type' => $currentType,
            'search' => $currentSearch,
        ]);
        
        return redirect($redirectUrl)->with('success', 'Jersey berhasil disetujui.');
    }

    /**
     * Tolak jersey dari pelanggan
     */
    public function rejectJersey(Jersey $jersey)
    {
        // Simpan informasi untuk redirect
        $currentPage = request('page', 1);
        $currentType = request('type', 'all');
        $currentSearch = request('search', '');
        
        $jersey->update([
            'status' => 'ditolak'
        ]);

        // Redirect kembali ke halaman yang sama dengan parameter yang sama
        $redirectUrl = route('admin.jerseys.index', [
            'page' => $currentPage,
            'type' => $currentType,
            'search' => $currentSearch,
        ]);
        
        return redirect($redirectUrl)->with('success', 'Jersey berhasil ditolak.');
    }
}
