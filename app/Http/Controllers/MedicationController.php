<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MedicationController extends Controller
{
    /**
     * Display the medication page.
     */
    public function index(): Response
    {
        return Inertia::render('Medication/Medication');
    }
}