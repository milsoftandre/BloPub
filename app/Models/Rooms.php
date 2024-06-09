<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'rooms';

    protected $fillable = [
        'employees_id_from', 'employees_id_to'
    ];

    public function from()
    {
        return $this->belongsTo(Employee::class, 'employees_id_from');
    }


    public function to()
    {
        return $this->belongsTo(Employee::class, 'employees_id_to');
    }
}
