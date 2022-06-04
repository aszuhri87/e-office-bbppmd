<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wish extends Model
{
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    // protected $guard_name = 'admin';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public function letter_wishes()
    {
        return $this->belongsTo(LetterWish::class, 'wish_id', 'id');
    }
}
