<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emlinks extends Model
{
    use HasFactory;
    protected $table = 'employees_links';

    protected $fillable = [
        'employees_id','employees_id_to'
    ];
}
