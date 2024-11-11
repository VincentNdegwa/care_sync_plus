<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    /**
     * Display the report page.
     */
    public function index(): Response
    {
        return Inertia::render('Report/Report');
    }
}