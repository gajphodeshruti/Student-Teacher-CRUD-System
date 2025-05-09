<?php
namespace App\Http\Controllers;

use App\Exports\TeacherExport;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\State;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\University;
use App\Models\College;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use App\Models\User;


class TeacherController extends Controller
{

    public function index1(Request $request)
    {

        $search = $request->input('search');
        $state_id = $request->input('state_id');
        $university_id = $request->input('university_id');
        $college_id = $request->input('college_id');
        $birthday_filter = $request->input('birthday_filter');
    
        $states = State::all();
        $universities = $state_id ? University::where('state_id', $state_id)->get() : collect();
        $colleges = $university_id ? College::where('university_id', $university_id)->get() : collect();
    
      
        $teachers = Teacher::with(['state', 'university', 'college']) 
        ->where('is_deleted', 0)
        ->when(auth()->user()->role !== 'admin', function ($query) {
            return $query->where('user_id', auth()->id());
        })
           
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('birthdate', 'like', "%{$search}%")
                      ->orWhere('gender', 'like', "%{$search}%")
                      ->orWhereHas('state', fn($q) => $q->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('university', fn($q) => $q->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('college', fn($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($state_id, fn($query) => $query->where('state_id', $state_id))
            ->when($university_id, fn($query) => $query->where('university_id', $university_id))
            ->when($college_id, fn($query) => $query->where('college_id', $college_id))
            ->when($birthday_filter, function ($query) use ($birthday_filter) {
                $today = now()->format('m-d');
                $weekStart = now()->startOfWeek()->format('m-d');
                $weekEnd = now()->endOfWeek()->format('m-d');
    
                if ($birthday_filter === 'today') {
                    $query->whereRaw("DATE_FORMAT(birthdate, '%m-%d') = ?", [$today]);
                } elseif ($birthday_filter === 'this_week') {
                    $query->whereRaw("DATE_FORMAT(birthdate, '%m-%d') BETWEEN ? AND ?", [$weekStart, $weekEnd]);
                } elseif ($birthday_filter === 'this_month') {
                    $query->whereMonth('birthdate', now()->month);
                }
            })
            ->paginate(10)
            ->withQueryString();
    
        return view('teacher.index', compact(
            'teachers',
            'search',
            'states',
            'universities',
            'colleges',
            'state_id',
            'university_id',
            'college_id',
            'birthday_filter'
        ));
    }    



    public function index()
    {
        $query = Teacher::with(['state', 'university', 'college'])
        ->where('is_deleted', 0);
    
        // Show only current user's teachers unless admin
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }
    
        $teachers = $query->orderBy('id', 'desc')->get();
    
        return view('teacher.index', compact('teachers'));
    }
    

    public function create()
    {
        $states = State::all();
        $universitys = [];
        $colleges = [];
        return view('teacher.create', compact('states', 'universitys', 'colleges'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:tbl_teacher,email',
        'birthdate' => 'required|date_format:Y-m-d',
        'mobileno' => 'required|regex:/^[6-9]\d{9}$/',
        'gender' => 'required|string',
        'state_id' => 'required|integer',
        'university_id' => 'required|integer',
        'college_id' => 'required|integer',
    ]);

    // Create teacher with validated and formatted data
    $teacher = new Teacher();
    $teacher->name = $request->name;
    $teacher->email = $request->email;
    $teacher->birthdate = Carbon::createFromFormat('Y-m-d', $request->birthdate);
    $teacher->mobileno = $request->mobileno;
    $teacher->gender = $request->gender;
    $teacher->state_id = $request->state_id;
    $teacher->university_id = $request->university_id;
    $teacher->college_id = $request->college_id;
   $teacher->user_id = auth()->id();

    // $teacher->user_id = auth()->id();
    $teacher->save();

    return redirect()->route('teacher.index')->with('success', 'Teacher added successfully!');
}

    public function getuniversity($stateId)
    {
        $universities = University::where('state_id', $stateId)->pluck('name', 'id');
        return response()->json($universities);
    }

    public function getcollege($universityId)
    {
        $colleges = College::where('university_id', $universityId)->get(['name', 'id']);
        return response()->json($colleges);
    }
    public function edit($id)
{
    $teacher = auth()->user()->role === 'admin'
        ? Teacher::findOrFail($id)
        :Teacher::where('id',$id)->where('user_id',auth()->id())->firstOrFail();
    $states = State::all(); // ✅ Fetch all states for the dropdown

    // Get universities and colleges only if teacher has selected them
    $universities = University::where('state_id', $teacher->state_id)->get();
    $colleges = College::where('university_id', $teacher->university_id)->get();

    return view('teacher.edit', compact('teacher', 'states', 'universities', 'colleges'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:tbl_teacher,email,' . $id, // ✅ Unique validation exception for current record
        'birthdate' => 'required|date',
        'mobileno' => 'required|regex:/^[6-9]\d{9}$/',
        'gender' => 'required|string',
        'state_id' => 'required|integer',
        'university_id' => 'required|integer',
        'college_id' => 'required|integer',
    ]);

    $teacher = Teacher::where('id', $id)
    ->when(auth()->user()->role !== 'admin', fn($q) => $q->where('user_id', auth()->id()))
    ->firstOrFail();
   
    
    $teacher->update($request->all());
   
    return redirect()->route('teacher.index')->with('success', 'Teacher updated successfully!');
}

    public function destroy($id)
    {
        $teacher = auth()->user()->role === 'admin'
        ? Teacher::findOrFail($id)
        :Teacher::where('id',$id)->where('user_id',auth()->id())->firstOrFail();
        $teacher->update(['is_deleted' => 1]);

        return redirect()->route('teacher.index')->with('success', 'Student deleted successfully.');
    }


    // If using DomPDF (Laravel default)
    
    public function exportPDF(Request $request)
{
    $query = Teacher::with(['state', 'university', 'college']);

    // Role-based access
    if (auth()->user()->role !== 'admin') {
        $query->where('user_id', auth()->id());
    }

    // Filters
    if ($request->filled('state_id')) {
        $query->where('state_id', $request->state_id);
    }
    if ($request->filled('university_id')) {
        $query->where('university_id', $request->university_id);
    }
    if ($request->filled('college_id')) {
        $query->where('college_id', $request->college_id);
    }
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('birthdate', 'like', "%{$search}%")
              ->orWhere('gender', 'like', "%{$search}%")
              ->orWhere('mobileno', 'like', "%{$search}%")
              ->orWhereHas('state', fn($q) => $q->where('name', 'like', "%{$search}%"))
              ->orWhereHas('university', fn($q) => $q->where('name', 'like', "%{$search}%"))
              ->orWhereHas('college', fn($q) => $q->where('name', 'like', "%{$search}%"));
        });
    }

    $teachers = $query->where('is_deleted', 0)->get();

    if ($teachers->isEmpty()) {
        return back()->with('error', 'No teachers found for the given criteria.');
    }

    $html = view('teacher.pdf', compact('teachers'))->render();

    try {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4', // You can also use A5 if needed
            'margin_top' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
        ]);

        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);

        return $mpdf->Output('teacher.pdf', 'I'); // 'I' to open in browser, use 'D' to force download
    } catch (\Mpdf\MpdfException $e) {
        return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
    }
}


  
    public function exportExcel(Request $request)
    {
        // Initialize the query builder
        $teachers = Teacher::with(['state', 'university', 'college'])
                            ->where('is_deleted', 0); // Exclude deleted records
    
        // Apply search filter if search term is provided
        $search = $request->input('search'); // Capture the search input
        if ($search) {
            $teachers->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('birthdate', 'like', "%{$search}%")
                      ->orWhere('gender', 'like', "%{$search}%")
                      ->orWhereHas('state', fn($q) => $q->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('university', fn($q) => $q->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('college', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }
    
        // Apply state_id filter if provided
        $search = $request->input('search');
        $state_id = $request->input('state_id');
        $university_id = $request->input('university_id');
        $college_id = $request->input('college_id');
    
        // Download the filtered teacher data as an Excel file
        return Excel::download(new TeacherExport($search, $state_id, $university_id, $college_id), 'teachers.xlsx');
    }
    public function autocomplete(Request $request)
    {
        $search = $request->get('value');
        $result = Teacher::select('name')
                    ->where('name', 'LIKE', "%{$search}%")
                    ->limit(10)
                    ->pluck('name');
    
        return response()->json($result);
    }
    public function superadmin()
{
    $user = auth()->user();

    if ($user->role == 'admin') {
        // Admin sees all entries
        $students = Student::where('is_deleted',0)->count();
        $teachers = Teacher::where('is_deleted',0)->count();
    } else {
        // Non-admin sees only their own entries based on email
        $students = Student::where('user_id', $user->id)
        ->where('is_deleted',0)
        ->count();
        $teachers = Teacher::where('email', $user->email)
        ->where('is_deleted',0)
        ->count();
    }

    $users = User::count(); // Optional: Count of all registered users

    return view('auth.dashboard', compact('students', 'teachers', 'users'));
}

    
}
?>