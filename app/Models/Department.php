<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'qac_id'
    ];

    public function qaCoordinator():HasOne
    {
        return $this->hasOne(User::class,'id','qac_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getQACoordinator()
    {
        return $this->qaCoordinator;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($department) {
            if($department->qaCoordinator)
            {
                $department->qaCoordinator->update([
                    'department_id' => $department->id,
                    'isQAC' => true
                ]);
            }
        });
    
        static::updated(function ($department) {
            if($department->getOriginal('qac_id') !== $department->qac_id) {
                if($department->qaCoordinator)
                {
                    $previousQAC = User::find($department->getOriginal('qac_id'));
                    if($previousQAC) {
                        $previousQAC->update([
                        'isQAC' => false,
                        'department_id' => null
                        ]);
                    }
                $department->qaCoordinator->update([
                    'department_id' => $department->id,
                    'isQAC' => true,
                    'isApproved' => true
                    ]);
                }
            }
        });
    }

    
}
