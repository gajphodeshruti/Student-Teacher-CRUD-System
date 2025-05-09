<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentExport implements FromQuery, WithMapping, WithHeadings, WithChunkReading
{
    protected $search;
    protected $state_id;
    protected $district_id;
    protected $taluka_id;

    // Constructor to accept search and other filter parameters
    public function __construct($search, $state_id = null, $district_id = null, $taluka_id = null)
    {
        $this->search = $search;
        $this->state_id = $state_id;
        $this->district_id = $district_id;
        $this->taluka_id = $taluka_id;
    }

    // Fetch filtered data
    public function query()
    {
        $query = Student::with(['state', 'district', 'taluka'])
                        ->where('is_deleted', 0);
                        // ->where('user_id', auth()->id());

        if ($this->state_id) {
            $query->where('state_id', $this->state_id);
        }

        if ($this->district_id) {
            $query->where('district_id', $this->district_id);
        }

        if ($this->taluka_id) {
            $query->where('taluka_id', $this->taluka_id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('birthdate', 'like', "%{$this->search}%")
                  ->orWhere('gender', 'like', "%{$this->search}%")
                  ->orWhere('mobileno', 'like', "%{$this->search}%")
                  ->orWhereHas('state', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('district', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('taluka', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
            });
        }

        return $query;
    }

    // Set column headings
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Birthdate',
            'Gender',
            'State',
            'District',
            'Taluka',
        ];
    }

    // Map data for Excel
    public function map($student): array
    {
        return [
            $student->id,
            $student->name,
            $student->email,
            $student->birthdate,
            $student->gender,
            $student->state->name ?? '-',
            $student->district->name ?? '-',
            $student->taluka->name ?? '-',
        ];
    }
    public function chunksize():int{
        return 1000;

    }
}
