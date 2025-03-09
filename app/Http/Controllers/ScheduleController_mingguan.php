<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;



class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('employee')->get()->groupBy('date');

if ($schedules->isEmpty()) {
    $schedules = [];
}
        return view('schedule.index', compact('schedules'));
    }
    public function calendar()
{
    $schedules = Schedule::with('employee')
        ->orderBy('date')  // Urutkan berdasarkan tanggal
        ->orderBy('shift') // Urutkan berdasarkan shift (1 → 2 → 3)
        ->get()
        ->groupBy('date'); // Kelompokkan berdasarkan tanggal

    $events = [];

    foreach ($schedules as $date => $shifts) {
        foreach ([1, 2, 3] as $shift) {
            $shiftEmployees = $shifts->where('shift', $shift)->pluck('employee.name')->toArray();
            if (!empty($shiftEmployees)) {
                $events[] = [
                    'title' => 'Shift ' . $shift . ': ' . implode(', ', $shiftEmployees),
                    'start' => $date,
                    'color' => '#3788d8',
                ];
            }
        }

        // Tambahkan karyawan yang libur
        $offEmployees = $shifts->where('is_holiday', true)->pluck('employee.name')->toArray();
        if (!empty($offEmployees)) {
            $events[] = [
                'title' => 'Libur: ' . implode(', ', $offEmployees),
                'start' => $date,
                'color' => '#FF5733',
            ];
        }
    }

    return response()->json($events);
}



public function generateSchedule()
{
    // Hapus jadwal lama
    Schedule::truncate();

    $employees = Employee::all();
    $dates = collect(range(0, 6))->map(fn($d) => Carbon::now()->startOfWeek()->addDays($d));

    // Track siapa yang sudah libur, siapa yang sudah mendapat shift per hari, dan siapa dari role 3 yang sudah masuk
    $employeeOffDays = [];
    $employeeDailyShifts = [];
    $role3Used = [];

    // Acak hari libur
    $days = collect(range(0, 6))->shuffle();
    $offDays = $days->reject(fn($d) => in_array($d, [4, 0]))->take(3)->merge([4, 0]); // Kamis & Minggu wajib 2 orang, sisanya acak
    
    foreach ($dates as $date) {
        $role1 = $employees->where('role', 1)->shuffle();
        $role2 = $employees->where('role', 2)->shuffle();
        $role3 = $employees->where('role', 3)->reject(fn($e) => isset($role3Used[$e->id]))->shuffle();

        $role1and2 = $role1->merge($role2)->shuffle();

        // **Tentukan siapa yang libur**
        $dayOffCount = in_array($date->dayOfWeek, [4, 0]) ? 2 : ($offDays->contains($date->dayOfWeek) ? 1 : 0);
        $availableForOff = $role1and2->reject(fn($e) => isset($employeeOffDays[$e->id]))->shuffle();
        $offEmployees = $availableForOff->take($dayOffCount);

        foreach ($offEmployees as $emp) {
            Schedule::create([
                'employee_id' => $emp->id,
                'date' => $date->toDateString(),
                'shift' => null,
                'is_holiday' => true
            ]);
            $employeeOffDays[$emp->id] = 1;
            $employeeDailyShifts[$date->toDateString()][$emp->id] = true;
        }

        // **Siapkan daftar shift**
        $shiftAssignments = [
            1 => collect(),
            2 => collect(),
            3 => collect(),
        ];

        // **Isi Shift 3 dengan Role 1 terlebih dahulu**
        $shift3Employees = $role1->reject(fn($e) => isset($employeeDailyShifts[$date->toDateString()][$e->id]))->take(2);

        // Jika ada yang libur, baru Role 3 masuk menggantikannya
        if ($offEmployees->count() > 0) {
            $role3Fillers = $role3->shuffle()->take($offEmployees->count());
            foreach ($role3Fillers as $emp) {
                $role3Used[$emp->id] = true;
            }
            $shift3Employees = $shift3Employees->splice(0, 2 - $role3Fillers->count())->merge($role3Fillers);
        }

        foreach ($shift3Employees as $emp) {
            Schedule::create([
                'employee_id' => $emp->id,
                'date' => $date->toDateString(),
                'shift' => 3,
            ]);
            $employeeDailyShifts[$date->toDateString()][$emp->id] = true;
            $shiftAssignments[3]->push($emp);
        }

        // **Isi Shift 1 dan 2 dengan Role 1 dan 2**
        foreach ([1, 2] as $shift) {
            $assignedEmployees = $role1and2->reject(fn($e) => isset($employeeDailyShifts[$date->toDateString()][$e->id]))->take(2);

            foreach ($assignedEmployees as $emp) {
                Schedule::create([
                    'employee_id' => $emp->id,
                    'date' => $date->toDateString(),
                    'shift' => $shift,
                ]);
                $employeeDailyShifts[$date->toDateString()][$emp->id] = true;
                $shiftAssignments[$shift]->push($emp);
            }
        }

        // **Pastikan semua karyawan yang tidak libur masuk shift**
        $unassignedEmployees = $employees->reject(fn($e) => isset($employeeDailyShifts[$date->toDateString()][$e->id]) || isset($employeeOffDays[$e->id]));

        foreach ($unassignedEmployees as $emp) {
            if ($emp->role == 2) {
                // Role 2 masuk shift 1 atau 2
                $availableShift = collect([1, 2])->first(fn($s) => $shiftAssignments[$s]->count() < 2);
            } elseif ($emp->role == 1) {
                // Role 1 masuk shift 2 atau 3
                $availableShift = collect([2, 3])->first(fn($s) => $shiftAssignments[$s]->count() < 2);
            } else {
                // Role 3 hanya boleh masuk shift 3 jika ada yang libur
                $availableShift = ($offEmployees->count() > 0 && $shiftAssignments[3]->count() < 2) ? 3 : null;
            }

            if ($availableShift) {
                Schedule::create([
                    'employee_id' => $emp->id,
                    'date' => $date->toDateString(),
                    'shift' => $availableShift,
                ]);
                $employeeDailyShifts[$date->toDateString()][$emp->id] = true;
                $shiftAssignments[$availableShift]->push($emp);
            }
        }
    }

    return redirect()->route('schedule.index')->with('success', 'Jadwal berhasil dibuat!');
}





public function exportSchedule()
{
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Header
    $section->addText('PEMERINTAH KABUPATEN CIAMIS', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
    $section->addText('DINAS KOMUNIKASI DAN INFORMATIKA', ['bold' => true, 'size' => 12], ['alignment' => 'center']);
    $section->addText('Jalan Jenderal Sudirman Nomor 220 Telepon. (0265) 773000, Fax (0265) 774257', ['size' => 10], ['alignment' => 'center']);
    $section->addText('Laman: https://diskominfo.ciamiskab.go.id, Pos 46215', ['size' => 10], ['alignment' => 'center']);
    $section->addTextBreak(1);
    
    $section->addText('JADWAL CALL TAKER 112 DISKOMINFO KAB.CIAMIS ' . Carbon::now()->translatedFormat('F Y'), ['bold' => true, 'size' => 12], ['alignment' => 'center']);
    $section->addText('(PER ' . Carbon::now()->format('d F Y') . ')', ['size' => 10], ['alignment' => 'center']);
    $section->addTextBreak(1);
    
    // Ambil data jadwal
    $schedules = Schedule::orderBy('date')->get()->groupBy('date');
    
    // Tambahkan tabel
    $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50]);
    
    // Header tabel
    $table->addRow();
    $table->addCell(2000)->addText('Tanggal', ['bold' => true]);
    $table->addCell(2000)->addText('Shift 1', ['bold' => true]);
    $table->addCell(2000)->addText('Shift 2', ['bold' => true]);
    $table->addCell(2000)->addText('Shift 3', ['bold' => true]);
    $table->addCell(2000)->addText('Libur', ['bold' => true]);
    
    foreach ($schedules as $date => $shifts) {
        $table->addRow();
        $table->addCell(2000)->addText(Carbon::parse($date)->translatedFormat('d-m-Y'));
        $table->addCell(2000)->addText(implode(', ', $shifts->where('shift', 1)->pluck('employee.name')->toArray()));
        $table->addCell(2000)->addText(implode(', ', $shifts->where('shift', 2)->pluck('employee.name')->toArray()));
        $table->addCell(2000)->addText(implode(', ', $shifts->where('shift', 3)->pluck('employee.name')->toArray()));
        $table->addCell(2000)->addText(implode(', ', $shifts->where('is_holiday', true)->pluck('employee.name')->toArray()));
    }
    
    // Footer (Tanda tangan elektronik)
    $section->addTextBreak(2);
    $section->addText('Ciamis, ' . Carbon::now()->translatedFormat('d F Y'), ['size' => 11]);
    $section->addTextBreak(1);
    $section->addText('Supervisor Call Taker 112 – Pranata Humas Ahli Muda', ['size' => 11]);
    $section->addText('Aep Nugraha S.Sos.', ['bold' => true, 'size' => 12]);
    $section->addText('NIP. 196709251991031004', ['size' => 11]);
    
    // Simpan file
    $fileName = 'JADWAL_CALL_TAKER_112_' . Carbon::now()->format('F_Y') . '.docx';
    $path = storage_path('app/public/' . $fileName);
    $phpWord->save($path);
    
    return response()->download($path)->deleteFileAfterSend();
}

















}


