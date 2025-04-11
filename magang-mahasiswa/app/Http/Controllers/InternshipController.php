<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function odd()
    {
        return view('internship.odd', [
            'title' => 'Praktik Profesional Semester Ganjil'
        ]);
    }

    public function even()
    {
        return view('internship.even', [
            'title' => 'Praktik Profesional Semester Genap'
        ]);
    }
}
