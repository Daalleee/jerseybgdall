<?php

namespace App\Http\Controllers;

use App\Models\Jersey;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Tampilkan form pembelian jersey
     */
    public function showBuyForm(Jersey $jersey)
    {
        // Pastikan jersey aktif
        if ($jersey->status !== 'aktif') {
            abort(404, 'Jersey tidak ditemukan atau belum disetujui.');
        }
        
        return view('transactions.buy_form', compact('jersey'));
    }

    /**
     * Proses pembelian jersey
     */
    public function buyJersey(Request $request, Jersey $jersey)
    {
        // Pastikan jersey aktif
        if ($jersey->status !== 'aktif') {
            abort(404, 'Jersey tidak ditemukan atau belum disetujui.');
        }
        
        $request->validate([
            'size' => 'required|in:S,M,L,XL',
            'buyer_address' => 'required|string|max:500',
            'buyer_phone' => 'required|string|max:15',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validasi ukuran yang dipilih tersedia
        $availableSizes = $jersey->sizes ? json_decode($jersey->sizes, true) : [$jersey->size];
        if (!in_array($request->size, $availableSizes)) {
            return redirect()->back()->withErrors(['size' => 'Ukuran yang dipilih tidak tersedia untuk jersey ini.'])->withInput();
        }

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');
        }

        Transaction::create([
            'jersey_id' => $jersey->id,
            'user_id' => Auth::id(),
            'buyer_address' => $request->buyer_address,
            'buyer_phone' => $request->buyer_phone,
            'payment_proof' => $paymentProofPath,
            'type' => 'pembelian',
            'status' => 'pending',
        ]);

        return redirect()->route('transactions.customer')->with('success', 'Pembelian berhasil diajukan. Admin akan segera memverifikasi pembayaran Anda.');
    }

    /**
     * Tampilkan riwayat transaksi pelanggan
     */
    public function customerTransactions(Request $request)
    {
        $pembelian = Auth::user()->transactions()
            ->where('type', 'pembelian')
            ->with('jersey')
            ->latest()
            ->paginate(5);
        
        // Untuk penjualan, kita ambil jersey yang dibuat oleh pelanggan ini (bukan transaksi)
        // Hanya jersey dari pelanggan sendiri
        $penjualan = Auth::user()->jerseys()
            ->where('type', 'pelanggan')
            ->with('transactions')
            ->latest()
            ->paginate(5);

        return view('transactions.customer_transactions', compact('pembelian', 'penjualan'));
    }

    /**
     * Tampilkan daftar transaksi untuk admin
     */
    public function adminIndex(Request $request)
    {
        $query = Transaction::with(['jersey', 'user']);
        
        // Filter berdasarkan status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            $request->merge(['status' => 'all']);
        }
        
        // Pencarian
        if ($request->has('search') && $request->search) {
            $query->whereHas('jersey', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        $transactions = $query->latest()->paginate(10);
        
        return view('admin.transactions', compact('transactions'));
    }

    /**
     * Setujui transaksi
     */
    public function approveTransaction(Transaction $transaction)
    {
        // Simpan informasi untuk redirect
        $currentPage = request('page', 1);
        $currentStatus = request('status', 'all');
        $currentSearch = request('search', '');
        
        $transaction->update([
            'status' => 'selesai'
        ]);

        // Redirect kembali ke halaman yang sama dengan parameter yang sama
        $redirectUrl = route('admin.transactions.index', [
            'page' => $currentPage,
            'status' => $currentStatus,
            'search' => $currentSearch,
        ]);
        
        return redirect($redirectUrl)->with('success', 'Transaksi berhasil disetujui.');
    }

    /**
     * Tolak transaksi
     */
    public function rejectTransaction(Transaction $transaction)
    {
        // Simpan informasi untuk redirect
        $currentPage = request('page', 1);
        $currentStatus = request('status', 'all');
        $currentSearch = request('search', '');
        
        $transaction->update([
            'status' => 'ditolak'
        ]);

        // Redirect kembali ke halaman yang sama dengan parameter yang sama
        $redirectUrl = route('admin.transactions.index', [
            'page' => $currentPage,
            'status' => $currentStatus,
            'search' => $currentSearch,
        ]);
        
        return redirect($redirectUrl)->with('success', 'Transaksi berhasil ditolak.');
    }
}
