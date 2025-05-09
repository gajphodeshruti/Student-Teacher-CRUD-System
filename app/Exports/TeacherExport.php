<?php
namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherExport implements FromQuery, WithMapping, WithHeadings
{
    protected $search;
    protected $state_id;
    protected $university_id;
    protected $college_id;

    public function __construct($search = null, $state_id = null, $university_id = null, $college_id = null)
    {
        $this->search = $search;
        $this->state_id = $state_id;
        $this->university_id = $university_id;
        $this->college_id = $college_id;
    }

    public function query()
    {
        $query = Teacher::with(['state', 'university', 'college'])
                        ->where('is_deleted', 0);

        // Apply filters based on provided inputs
        if (!empty($this->state_id)) {
            $query->where('state_id', $this->state_id);
        }

        if (!empty($this->university_id)) {
            $query->where('university_id', $this->university_id);
        }

        if (!empty($this->college_id)) {
            $query->where('college_id', $this->college_id);
        }

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('birthdate', 'like', "%{$this->search}%")
                  ->orWhere('gender', 'like', "%{$this->search}%")
                  ->orWhere('mobileno', 'like', "%{$this->search}%")
                  ->orWhereHas('state', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('university', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('college', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Birthdate',
            'Gender',
            'Mobile No',
            'State',
            'University',
            'College',
        ];
    }

    public function map($teacher): array
    {
        return [
            $teacher->id,
            $teacher->name,
            $teacher->email,
            $teacher->birthdate,
            $teacher->gender,
            $teacher->mobileno,
            $teacher->state->name ?? '-',
            $teacher->university->name ?? '-',
            $teacher->college->name ?? '-',
        ];
    }
}

?>