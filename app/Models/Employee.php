<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends BaseModel
{
    protected $fillable = ['tenant_id', 'name', 'email'];

}
