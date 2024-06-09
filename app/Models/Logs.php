<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $table = 'logs';

    protected $fillable = [
        'employees_id','text','task_id'
    ];

    public function employeesid()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }
}
