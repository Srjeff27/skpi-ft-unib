<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function skpi(Request $request, User $user): View
    {
        // Middleware 'signed' di route memastikan URL valid
        $verifiedCount = $user->portfolios()->where('status','verified')->count();
        return view('public.verification.skpi', compact('user','verifiedCount'));
    }
}

