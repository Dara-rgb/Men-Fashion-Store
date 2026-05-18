<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    // បង្ហាញ Form Register
    public function showRegister() {
        return view('Back_end.show_register');
    }

    // បង្ហាញ Form Login
    public function showLogin() {
        return view('Back_end.show_login');
    }
    public function showLoginConfirm() {
        return view('Back_end.show_login_confirm');
    }
    public function showFormSecurity() {
        $users = User::orderBy('id', 'DESC')->get();
        return view('Back_end.show_form_security', compact('users'));
    }
    public function Showformforforgot(){
        return view('Back_end.show_form_for_forgot');
    }
    public function showFormEdit($id) {
        if (!session()->pull('password_verified_at')) {
            return redirect()->route('Back_end.show_login_confirm');
        }
        
        $users = User::findOrfail($id);
        return view('Back_end.show_form_edit', compact('users'));
    }
    public function showLogout() {
        return view('Back_end.show_logout');
    }
    // មុខងារចុះឈ្មោះ (សម្រាប់បងបង្កើត account ខ្លួនឯងលើកដំបូង)
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:users',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password), // Encrypt password
        ]);

        return "Account បង្កើតជោគជ័យ! ឥឡូវបងអាច Login បានហើយ។";
    }

    // មុខងារ Login
    public function login(Request $request) {
        // ១. Validate ទិន្នន័យពី Form
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        // ២. ទាញ User ទាំងអស់មក (Collection) ដើម្បីឱ្យ Laravel ដោះកូដ (Decrypt) ឈ្មោះ និងលេខទូរស័ព្ទមកផ្ទៀងផ្ទាត់
        // ការប្រើ filter នេះនឹងដំណើរការ Decrypt អូតូតាមរយៈ Model Casts ដែលបងបានដាក់
        $user = \App\Models\User::all()->filter(function($u) use ($request) {
            return $u->name === $request->name && $u->phone_number === $request->phone_number;
        })->first();

        // ៣. បើរកឃើញ User ហើយ ឆែក Password បន្តទៀត
        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            // បើត្រូវទាំងអស់ ឱ្យវា Login ចូល
            \Illuminate\Support\Facades\Auth::login($user);
            
            $request->session()->regenerate();
            
            // បញ្ជាក់៖ ត្រង់នេះ redirect ទៅ route name ឬ URL (ឧទាហរណ៍៖ dashboard)
            return redirect()->intended(route('Back_end.index')); 
        }

        // ៤. បើខុសលក្ខខណ្ឌណាមួយ ឱ្យត្រឡប់ទៅវិញជាមួយសារ Error
        return back()->withErrors([
            'phone_number' => 'ឈ្មោះ លេខសម្គាល់តេឡេក្រាម ឬពាក្យសម្ងាត់ មិនត្រឹមត្រូវ!'
        ])->withInput();
    }

    public function securityUpdate(Request $request, $id) {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->phone_number = $request->input('phone_number');

        // ឆែកមើលថា បើមានការវាយ Password ចូល ទើបយើង Update និង Hash វា
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        session()->forget('password_verified_at');

        return redirect()->route('Back_end.index')->with('success', 'ព័ត៌មានសម្ងាត់កែប្រែបានជោគជ័យ');
    }

    public function login_confirm(Request $request) {
        // ១. Validate ទិន្នន័យពី Form
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        // ២. ទាញ User ទាំងអស់មក (Collection) ដើម្បីឱ្យ Laravel ដោះកូដ (Decrypt) ឈ្មោះ និងលេខទូរស័ព្ទមកផ្ទៀងផ្ទាត់
        // ការប្រើ filter នេះនឹងដំណើរការ Decrypt អូតូតាមរយៈ Model Casts ដែលបងបានដាក់
        $user = \App\Models\User::all()->filter(function($u) use ($request) {
            return $u->name === $request->name && $u->phone_number === $request->phone_number;
        })->first();

        // ៣. បើរកឃើញ User ហើយ ឆែក Password បន្តទៀត
        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            \Illuminate\Support\Facades\Auth::login($user);
            $request->session()->regenerate();

            // បង្កើត Session សុវត្ថិភាពដែលបងចង់បាន
            session(['password_verified_at' => time()]);

            // សាកល្បងប្រើបែបនេះវិញ ចំគោលដៅតែម្តង
            return redirect()->route('Back_end.show_form_edit', ['id' => $user->id]);
        }

        // ៤. បើខុសលក្ខខណ្ឌណាមួយ ឱ្យត្រឡប់ទៅវិញជាមួយសារ Error
        return back()->withErrors([
            'phone_number' => 'ឈ្មោះ លេខសម្គាល់តេឡេក្រាម ឬពាក្យសម្ងាត់ មិនត្រឹមត្រូវ!'
        ])->withInput();
    }

    public function sendOtpToAdmin(Request $request) {
        $request->validate([
        'phone_number' => 'required'
    ]);

    // ១. ទទួលលេខពី Form ទាំងស្រុង (បើគាត់វាយ 012345678 គឺទុក 012345678 ដដែល)
        $user = \App\Models\User::all()->filter(function($u) use ($request) {
            return $u->phone_number === $request->phone_number;
        })->first();

        if (!$user) {
            return back()->withErrors([
                'phone_number' => 'រកមិនឃើញលេខសម្គាល់តេឡេក្រាមនេះក្នុងប្រព័ន្ធទេ!'
            ]);
        }

        // Generate OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save session
        session([
            'otp_code' => $otp,
            'otp_user_id' => $user->id,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        try {

            // 🔥 Telegram BOT (ដាក់ផ្ទាល់ក្នុង controller)
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $chatId   = "$request->phone_number"; // 👈 Telegram ID របស់អ្នក

            $message = "🔐 OTP SYSTEM\n"
                    . "User: {$user->phone_number}\n"
                    . "OTP: {$otp}\n"
                    . "Expire: 5 minutes";

            Http::get("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message
            ]);

            return redirect()->route('Back_end.show_form_pincode')->with('success', 'OTP ផ្ញើទៅ Telegram ហើយ!');

        } catch (\Exception $e) {

            return back()->withErrors([
                'telegram' => $e->getMessage()
            ]);
        }
    }
    public function verifyPincode(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // 1. Check OTP match
        if ($request->otp != session('otp_code')) {

            return back()->withErrors([
                'otp' => 'PIN មិនត្រឹមត្រូវ'
            ]);
        }

        // 2. Check expire time
        if (now()->gt(session('otp_expires_at'))) {

            return back()->withErrors([
                'otp' => 'PIN ផុតកំណត់ហើយ'
            ]);
        }

        // 3. Get user
        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return back()->withErrors([
                'otp' => 'User មិនមានក្នុងប្រព័ន្ធ'
            ]);
        }

        // 4. Login user
        session([
            'verified_otp_user_id' => $user->id
        ]);

        // 5. Clear session
        session()->forget([
            'otp_code',
            'otp_user_id',
            'otp_expires_at'
        ]);

        return redirect()->route('Back_end.show_form_edit_new', ['id' => $user->id]);
    }
    public function showFromPincode()
    {
        return view('Back_end.show_form_pincode');
    }
    public function showFormEditNew($id){
        // ❌ បើ login រួច មិនអោយចូល page នេះ
        if (auth()->check()) {

            return redirect()->route('Back_end.index');
        }
        // 🔥 pull = យក session ម្តងហើយលុបភ្លាម
            $verifiedUserId = session()->pull('verified_otp_user_id');

        // 🔒 check OTP verified
        if ($verifiedUserId != $id) {

            return redirect()->route('Back_end.show_form_for_forgot');
        }
        
        $users = User::findOrfail($id);
        return view('Back_end.show_form_edit_new', compact('users'));
    }
    public function securityUpdateNew(Request $request, $id) {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->phone_number = $request->input('phone_number');

        // ឆែកមើលថា បើមានការវាយ Password ចូល ទើបយើង Update និង Hash វា
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        //auth()->login($user);
        return redirect()->route('Back_end.index')->with('success', 'ព័ត៌មានសម្ងាត់បញ្ចូលជាថ្មីបានជោគជ័យ');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('Back_end.show_login');
    }
}
