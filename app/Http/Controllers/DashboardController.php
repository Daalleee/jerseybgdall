<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jersey;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function adminDashboard()
    {
        // Hanya untuk admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $totalJerseys = Jersey::count();
        $activeJerseys = Jersey::where('status', 'aktif')->count();
        $totalCustomers = User::where('role', 'pelanggan')->count();
        $totalTransactions = Transaction::count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalJerseys',
            'activeJerseys',
            'totalCustomers',
            'totalTransactions',
            'pendingTransactions'
        ));
    }

    /**
     * Tampilkan dashboard pelanggan
     */
    public function customerDashboard()
    {
        // Hanya untuk pelanggan
        if (Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        // Hanya jersey sistem yang aktif
        $availableJerseys = Jersey::where('status', 'aktif')->where('type', 'sistem')->get();

        return view('customer.dashboard', compact(
            'availableJerseys'
        ));
    }
}
