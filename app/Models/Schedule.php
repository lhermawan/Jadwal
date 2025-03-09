<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'date', 'shift', 'is_holiday'];

    // Tambahkan relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
}
