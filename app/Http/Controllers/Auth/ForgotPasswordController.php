<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;

use App\Mail\Email;


class ForgotPasswordController extends Controller
{
    function showLinkRequestForm()
    {
        return view('auth.passwords.reset');
    }

    function forgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        try {
            Mail::to($request->email)->send(new Email($token));
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['email' => 'Failed to send reset email. Please try again later.']);
        }

        return redirect()->to(route("login"))->with('status', 'We have emailed your password reset link!');
    }

    public function resetPassword($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            return redirect()->route('login')->with('error', 'Invalid Reset link!');
        }

        $createdAt = Carbon::parse($passwordReset->created_at);

        if ($createdAt->addMinutes(30)->isPast()) {
            return redirect()->route('login')->with('error', 'Your Reset link has expired!');
        }

        return view('auth.passwords.confirm', compact('token'));
    }

    function resetPasswordPost(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users",
            "password" => "required|string|min:8|confirmed",
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                "email" => $request->email,
                "token" => $request->token
            ])->get();

        if ($updatePassword->isEmpty()) {
            return redirect()->to(route("reset.password", $request->token))->with("error", "Invalid token or email.");
        }

        $user = User::where("email", $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table("password_resets")->where(["email" => $request->email])->delete();

        return redirect()->to(route("login"))->with("success", "Password reset successfully!");
    }
}
