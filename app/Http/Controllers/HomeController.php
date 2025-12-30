<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Tickets;
use App\Models\contact_us;
use App\Models\TicketBooking;
use App\Models\orders_confirm;
use App\Models\coupans;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Models\rise\Sliders;
use App\Models\rise\Headings;
use App\Models\rise\Courses;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\alert;
use App\Models\rise\AdminContactUs;
use App\Models\rise\AboutUs;

class HomeController extends Controller
{
    
    public function index()
    {
        // Fetch active sliders
        $sliders = Sliders::where('status', 1)->get();
        
        // Fetch parent headings with active children
        $parents = Headings::whereNull('heading_id')
            ->where(function($query) {
                $query->where('status', 1)
                      ->orWhere('isFeatured', 1);
            })
            ->with(['children' => function ($query) {
                $query->where('status', 1)->orderBy('order_no', 'asc');
            }])
            ->orderBy('order_no', 'asc')
            ->take(4)
            ->get();
            
        Log::info('Home page data loaded', [
            'sliders' => $sliders->toArray(),
            'parents' => $parents->toArray(),
        ]);
        
        // Return view with data
        return view('index', compact('sliders', 'parents'));
    }

  
    public function aboutus()
    {
        $about = AboutUs::first();
        return view('aboutus', compact('about'));
    }
  public function terms_conditions()
  {
    return view('terms_conditions');
  }
  public function policy()
  {
    return view('policy');
  }
  public function refund_policy()
  {
    return view('refund_policy');
  }
  public function Gallery()
  {
    return view('Gallery');
  }

  public function otpVerifyView()
  {
    return view('verify_otp');
  }
  
  public function signup()
  {
    return view('signup');
  }
  
  public function login()
  {
    return view('login');
  }
  
  public function userDashboard()
  {
      return view('index');
  }

  public function verifyOtp(Request $request)
  {
    $request->validate([
      'otp' => 'required|digits:6',
    ]);

    $user = DB::table('users')->where('otp', $request->otp)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'Invalid OTP or number.');
    }
    
    if (now()->gt($user->otpExpiryTime)) {
        return redirect()->back()->with('error', 'OTP expired.');
    }
    
    // ✅ Update status to Active
    DB::table('users')
        ->where('id', $user->id)
        ->update([
            'status' => 'Active',
            'otp' => null, // optional: clear OTP
            'is_verified' => true
        ]);
    
    return redirect()->route('front.login')
                     ->with('success', 'OTP verified successfully. Please login.');

  }

    public function registration(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nubhar' => 'required|digits:10|numeric|unique:users,nubhar',
            'password' => 'required|min:6|same:RePassword',
            'RePassword' => 'required|min:6',
        ], [
            'email.unique' => 'This email is already registered.',
            'nubhar.unique' => 'This mobile number is already registered.',
            'nubhar.digits' => 'Mobile number must be exactly 10 digits.',
            'nubhar.numeric' => 'Mobile number must contain only digits.',
        ]);
    
        // Create user
        User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'nubhar' => $validated['nubhar'],
            'password' => bcrypt($validated['password']),
        ]);
    
        return redirect()->route('front.login')->with(['success' => 'Registration successful!']);
    }

    public function frontlogin(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // true if checkbox checked
    
        if (Auth::attempt($credentials, $remember)) {
            // Login successful
            $request->session()->regenerate(); // prevent session fixation
            return redirect()->route('user.index'); // change to your intended page
        }
     
        // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function frontLogout(Request $request)
    {
        Auth::logout(); // no need for guard('users') unless custom guard used
    
        $request->session()->forget(['user_id', 'couponlogin']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('front.login')->with('success', 'You have been logged out successfully.');
    }


    public function ContactUsadd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'agree_terms_and_policy' => 'accepted',
        ]);
    
        contact_us::create([
            'name'    => $validatedData['name'],
            'email'   => $validatedData['email'],
            'phone'   => $validatedData['phone'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['content'],
        ]);
    
        return redirect()
            ->back()
            ->with('success', 'Message sent successfully!');
    }
  
    public function courses(Request $request)
    {
        $courses = Courses::where('status', 1)
            ->where('showOnFront', 1)
            ->get();
    
        return view('admin.Rise.courses', compact('courses'));
    }

    public function contactUs()
    {
        $contact = AdminContactUs::first();
        return view('contact-us', compact('contact'));
    }


}
