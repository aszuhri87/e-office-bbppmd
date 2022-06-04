<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterUser extends Model
{
    use SoftDeletes;
    use Uuid;

    public $incrementing = false;

    // protected $guard_name = 'admin';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'notes',
        'user_id',
        'letter_id',
    ];

    protected $dates = ['deleted_at'];
}
