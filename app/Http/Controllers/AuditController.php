<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    //
    public function index()
    {
        $logs = Log::paginate(10);
        return view('audit.index',compact('logs'));
    }
}
