<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\State;
use App\Models\District;
use App\Models\Taluka;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentExport;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $state_id = $request->input('state_id');
        $district_id = $request->input('district_id');
        $taluka_id = $request->input('taluka_id');
        $birthday_filter = $request->input('birthday_filter');

        $states = State::all();
        $districts = $state_id ? District::where('state_id', $state_id)->get() : collect();
        $talukas = $district_id ? Taluka::where('district_id', $district_id)->get() : collect();

        $students = Student::with(['state', 'district', 'taluka'])
        ->where('is_deleted', 0) // Filter to show only non-deleted students
        ->when(auth()->user()->role !== 'admin', fn($q) => $q->where('user_id', auth()->id()))
        ->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('birthdate', 'like', "%{$search}%")
                    ->orWhere('gender', 'like', "%{$search}%")
                    ->orWhere('mobileno', 'like', "%{$search}%")
                    ->orWhereHas('state', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('district', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('taluka', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        })
        ->when($state_id, fn($q) => $q->where('state_id', $state_id))
        ->when($district_id, fn($q) => $q->where('district_id', $district_id))
        ->when($taluka_id, fn($q) => $q->where('taluka_id', $taluka_id))
        ->when($birthday_filter, function ($q) use ($birthday_filter) {
            if ($birthday_filter === 'today') {
                $q->whereRaw("DATE_FORMAT(birthdate, '%m-%d') = ?", [now()->format('m-d')]);
            } elseif ($birthday_filter === 'this_week') {
                $q->whereRaw("DATE_FORMAT(birthdate, '%m-%d') BETWEEN ? AND ?", [
                    now()->startOfWeek()->format('m-d'),
                    now()->endOfWeek()->format('m-d'),
                ]);
            } elseif ($birthday_filter === 'this_month') {
                $q->whereMonth('birthdate', now()->month);
            }
        })
        ->paginate(10)
        ->withQueryString();
        
        return view('auth.index', compact(
            'students', 'search', 'states', 'districts', 'talukas',
            'state_id', 'district_id', 'taluka_id', 'birthday_filter'
        ));
    }
    public function create()
    {
        $states = State::all();
        return view('students.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'birthdate' => 'required|date',
            'gender' => 'required|string',
            'class' => 'required|string',
            'mobileno' => 'required|regex:/^[6-9]\d{9}$/',
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'taluka_id' => 'required|exists:talukas,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthdate' => Carbon::parse($request->birthdate)->format('Y-m-d'),
            'gender' => $request->gender,
            'class' => $request->class,
            'mobileno' => $request->mobileno,
            'state_id' => $request->state_id,
            'district_id' => $request->district_id,
            'taluka_id' => $request->taluka_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('auth.index')->with('success', 'Student added successfully!');
    }

    public function edit($id)
    {
        $student = auth()->user()->role === 'admin'
            ? Student::findOrFail($id)
            : Student::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $states = State::all();
        $districts = District::where('state_id', $student->state_id)->get();
        $talukas = Taluka::where('district_id', $student->district_id)->get();

        return view('students.edit', compact('student', 'states', 'districts', 'talukas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'birthdate' => 'required|date',
            'gender' => 'required|string',
            'class' => 'required|string',
            'mobileno' => 'required|regex:/^[6-9]\d{9}$/',
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'taluka_id' => 'required|exists:talukas,id',
        ]);

        $student = Student::where('id', $id)
            ->when(auth()->user()->role !== 'admin', fn($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
           'birthdate' => Carbon::parse($request->birthdate)->format('Y-m-d'),
            'gender' => $request->gender,
            'class' => $request->class,
            'mobileno' => $request->mobileno,
            'state_id' => $request->state_id,
            'district_id' => $request->district_id,
            'taluka_id' => $request->taluka_id,
        ]);

        return redirect()->route('auth.index')->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        // Retrieve student record, making sure to respect the user's access rights
        $student = auth()->user()->role === 'admin'
            ? Student::findOrFail($id)
            : Student::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    
        // Soft delete: set is_deleted to 1
        $student->update(['is_deleted' => 1]);
    
        // Redirect to dashboard
        return redirect()->route('auth.index')->with('success', 'Student deleted successfully.');
    }
    
    

    public function getDistricts($id)
    {
        $districts = District::where('state_id', $id)->pluck('name', 'id');
        return response()->json($districts);
    }

    public function getTalukas($id)
    {
        $talukas = Taluka::where('district_id', $id)->get(['name', 'id']);
        return response()->json($talukas);
    }

    public function exportPdf(Request $request)
{
    set_time_limit(0);
    ini_set('memory_limit', '-1');

    $query = Student::with(['state:id,name', 'district:id,name', 'taluka:id,name'])
        ->select('id', 'name', 'email', 'state_id', 'district_id', 'taluka_id')
        ->where('is_deleted', 0);

    if ($request->filled('state_id')) {
        $query->where('state_id', $request->state_id);
    }
    if ($request->filled('district_id')) {
        $query->where('district_id', $request->district_id);
    }
    if ($request->filled('taluka_id')) {
        $query->where('taluka_id', $request->taluka_id);
    }
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhereHas('state', fn($q) => $q->where('name', 'like', "%{$search}%"))
              ->orWhereHas('district', fn($q) => $q->where('name', 'like', "%{$search}%"))
              ->orWhereHas('taluka', fn($q) => $q->where('name', 'like', "%{$search}%"));
        });
    }

    $students = $query->limit(150000)->get();

    if ($students->isEmpty()) {
        return back()->with('error', 'No students found for the given criteria.');
    }

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_top' => 10,
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_bottom' => 10,
        'tempDir' => storage_path('app/temp'),
    ]);

    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML('<h2 style="text-align:center;">Student List</h2>');

    // Process students in smaller chunks to avoid memory issues
    $students->chunk(1000)->each(function ($chunk) use ($mpdf) {
        $html = view('students.pdf', ['students' => $chunk])->render();
        $mpdf->WriteHTML($html);
    });

    return response($mpdf->Output('students.pdf', 'I'))
        ->header('Content-Type', 'application/pdf');
}

    public function exportExcel(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $search = $request->input('search');
        $state_id = $request->input('state_id');
        $district_id = $request->input('district_id');
        $taluka_id = $request->input('taluka_id');

        return Excel::download(new StudentExport($search, $state_id, $district_id, $taluka_id), 'student.xlsx');
    }

    public function autocomplete(Request $request)
    {
        $result = Student::where('user_id', auth()->id())
            ->where('name', 'like', "%" . $request->value . "%")
            ->limit(10)
            ->pluck('name');

        return response()->json($result);
    }
}
