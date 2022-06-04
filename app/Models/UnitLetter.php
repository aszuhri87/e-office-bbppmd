<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitLetter extends Model
{
    use SoftDeletes;
    use Uuid;

    public $incrementing = false;

    // protected $guard_name = 'admin';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'letter_id',
        'letter_user_id',
        'notes',
    ];

    protected $dates = ['deleted_at'];

    public function letter_wish()
    {
        return $this->belongsTo(LetterWish::class, 'id', 'unit_letter_id');
    }
}
