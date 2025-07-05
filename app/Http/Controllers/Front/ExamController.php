<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ExamController extends Controller
{
    private function checkAccess(Exam $exam): bool
    {
        if (!$exam->status) return false;
        return true;
    }

    public function exercise($code) :View|RedirectResponse
    {
        $exam = Exam::where('code', $code)->first();
        if (!$exam) return redirect()->back()->with('error', '404 Not Found');
        $ok = $this->checkAccess($exam);
        if (!$ok) {
            return view('front.content.exam.error', ['exam' => $exam]);
        }
        $data['exam'] = $exam;
        $exam->load('parts');
        $data['leftTime'] = $exam->time * 60; // Convert time to seconds

        return view('front.content.exam.detail', $data);
    }

    public function todo($code) :View|RedirectResponse
    {
        $exam = Exam::where('code', $code)->first();
        if (!$exam) return redirect()->back()->with('error', '404 Not Found');

        $data['exam'] = $exam;
        $data['leftTime'] = $exam->time * 60; // Convert time to seconds
        return view('front.content.exam.detail', $data);
    }
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

    public function auth()
    {
        return view('front.content.exam.auth',
            [
                'page' => 'exam.auth',
            ]
        );
    }
}
