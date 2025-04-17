<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class SendPasswordLinkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = Password::sendResetLink([
            'email' => auth()->user()->email
        ]);

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status))
            ->with('success', 'Doğrulama bağlantısı e-posta adresinize gönderilidi');
        }

    }

}
