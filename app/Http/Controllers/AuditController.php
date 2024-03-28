<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    //
    public function index()
    {
        $logs = Log::latest()->paginate();
        return view('audit.index',compact('logs'));
    }
}
