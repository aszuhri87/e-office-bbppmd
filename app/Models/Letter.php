<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    // protected $guard_name = 'admin';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'created_by',
        'name',
        'from',
        'letter_number',
        'date',
        'received_date',
        'agenda_number',
        'trait',
        'about',
        'status',
        'signature_id',
        'letter_file',
    ];

    protected $dates = ['deleted_at'];

    public function letter_user()
    {
        return $this->hasMany(LetterUser::class, 'letter_id', 'id');
    }

    public function unit_letter()
    {
        return $this->hasMany(UnitLetter::class, 'letter_id', 'id');
    }
}
