<?php
// Lokasi: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;

class DashboardController extends Controller
{
    /** GET /dashboard */
    public function index()
    {
        $res = ApiHelper::get('/admin/dashboard');

        $stats        = ApiHelper::extractData($res, 'stats', []);
        $charts       = ApiHelper::extractData($res, 'charts', []);
        $recentOrders = ApiHelper::extractData($res, 'recent_orders', []);
        $calendarBookings = ApiHelper::extractData($res, 'calendarBookings', []);
        $pendingTasks = ApiHelper::extractData($res, 'pendingTasks', []);
        $topPartners  = ApiHelper::extractData($res, 'topPartners', []);

        return view('dashboard.index', compact('stats', 'charts', 'recentOrders', 'calendarBookings', 'pendingTasks', 'topPartners'));
    }
}