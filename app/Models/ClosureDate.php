<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClosureDate extends Model
{
    use HasFactory;
    protected $table = 'closure_dates';

    protected $fillable = [
        'academic_year',
        'post_end_date',
        'comment_end_date',
    ];
    protected $casts = [
        'academic_year' => 'integer',
        'post_end_date' => 'date',
        'comment_end_date' => 'date',
    ];
    // protected $dates = ['post_closure_date','comment_closure_date'];
    public $timestamps = false;
    // public $timestamps = ['post_closure_date','comment_closure_date'];

    public static function isClosureDate()
    {
        $closureDate = ClosureDate::where('academic_year', date('Y'))->first();

        if(!$closureDate) {
            return true;
        }
        if ($closureDate) {
            $postEndDate = $closureDate->post_end_date;

            if (carbon::now()->lte($postEndDate)) {
                return true;
            }
        }

        return false;
    }
}
