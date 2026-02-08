<?php

namespace Modules\Materiais\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ncm extends Model
{
    use HasFactory;

    protected $table = 'ncms';

    protected $fillable = [
        'code',
        'description',
        'category',
    ];
}
