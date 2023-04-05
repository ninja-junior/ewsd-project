<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
        'isApproved',
        'isQAM',
        'isQAC',

    ];
    protected $with=['department'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isApproved'=>'boolean',
        'isQAM'=>'boolean',
        'isQAC'=>'boolean',
        'isAdmin'=>'boolean',
    ];

    public function canAccessFilament(): bool
    {
        // return $this->hasRole(['admin', 'qam','qac']);
      
        return ($this->isQAC() || $this->isQAM() ||$this->isAdmin);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function isQAM()
    {
        return $this->isQAM;
    }

    public function isQAC()
    {
        return $this->isQAC;
    }
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function isClosureDate()
    {
        $closureDate = ClosureDate::where('academic_year', date('Y'))->first();

        if(!$closureDate) {
            return true;
        }
        if ($closureDate) {
            $postEndDate = $closureDate->post_end_date;

            if (now()->lte($postEndDate)) {
                return true;
            }
        }

        return false;
    }
}
