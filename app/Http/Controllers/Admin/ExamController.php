<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    /**
     * Display the listening exam page.
     *
     * @return \Illuminate\View\View
     */
    public function listen() :View
    {
        return view('front.content.exam.listen',
            [
                'page' => 'exam.listen',
            ]
        );
    }
    public function read() :View
    {
    return view('front.content.exam.read',
        [
            'page' => 'exam.read',
        ]
    );
}
}
