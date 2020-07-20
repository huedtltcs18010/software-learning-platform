<?php

namespace App\Http\Controllers\Admin;

class DashboardController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}
