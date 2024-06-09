<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';

    protected $fillable = [
        'employees_id', 'room_id', 'text' 
    ];

    public function from()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }
}
