<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; 
use App\Models\User;

class DashboardController extends Controller
{
     public function index()
    {
        // Hitung jumlah data dari masing-masing model
        $categoryCount = Category::count();
        $userCount = User::count();

        // Kirim data hitungan ke view
        return view('admin.dashboard', compact('categoryCount', 'userCount'));
    }
}
