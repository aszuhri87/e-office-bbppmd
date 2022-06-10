<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterWish extends Model
{
    use SoftDeletes;
    use Uuid;

    public $incrementing = false;

    // protected $guard_name = 'admin';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'unit_letter_id',
        'wish_id',
        'other_wishes',
    ];

    protected $dates = ['deleted_at'];

    public function wishes()
    {
        return $this->belongsTo(Wish::class, 'wish_id', 'id');
    }
}
