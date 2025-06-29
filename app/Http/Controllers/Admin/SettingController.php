<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function media() :View
    {
        // Logic to handle media settings
        return view('admin.content.setting.media', ['page' => 'manage-media',]);
    }
}
