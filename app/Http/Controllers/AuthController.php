<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\State;
use App\Models\District;
use App\Models\Taluka;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Show Registration Form
    public function index()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,student,teacher',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Auto login the user
        Auth::login($user);

        // Redirect to login with message
        return redirect()->route('login')->with('success', 'Registered successfully! Please log in.');
    }

    // Show Login Form
    public function loginView()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Role-based redirection
            if ($user->role === 'admin') {
                return redirect()->route('auth.index');
            } elseif ($user->role === 'student') {
                return redirect()->route('auth.index');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('teacher.index');
            }

            return redirect()->route('auth.index');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Student Dashboard with Filters (for logged-in user)
    public function dashboard(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            // Redirect to login if not authenticated
            return redirect()->route('login');
        }
    
        // User is authenticated, continue with the logic
        $query = Student::with(['state', 'district', 'taluka'])
            ->where('is_deleted', 0);
    
        if (auth()->user()->role != 'admin') {
            // Non-admin users should only see their own data
            $query->where('user_id', Auth::id());
        }
    
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }
    
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }
    
        if ($request->filled('taluka_id')) {
            $query->where('taluka_id', $request->taluka_id);
        }
    
        $students = $query->paginate(10)->withQueryString();
    
        return view('auth.index', [
            'students'  => $students,
            'states'    => State::all(),
            'districts' => District::all(),
            'talukas'   => Taluka::all()
        ]);
    }
     // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }

    // Show Profile Page
    public function show()
    {
        return view('auth.profile');
    }

    // Upload Profile Image
    public function upload(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();

        // Delete old image if exists
        if ($user->profile_image && file_exists(public_path('profile_images/' . $user->profile_image))) {
            unlink(public_path('profile_images/' . $user->profile_image));
        }

        $imageName = time() . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path('profile_images'), $imageName);

        DB::table('users')->where('id', $user->id)->update(['profile_image' => $imageName]);

        return back()->with('success', 'Profile image uploaded successfully.');
    }

    // Show Change Password Form
    public function showChangePasswordForm()
    {
        return view('auth.changepassword');
    }

    // Handle Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();

        return redirect()->route('login')->with('status', 'Password changed successfully! Please log in again.');
    }
}
