<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PostCreatedNotification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory,Notifiable;
    public $policy;

    protected $guarded=['policy'];
    // protected $fillable=[
    //     'title','slug','content'
    // ];

    protected $with = ['category', 'author','votes'];
    protected $casts = [
        'published_at' => 'date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function totalUpVote()
    {
        return $this->votes->where('vote','up')->count();
    }
    public function totalDownVote()
    {
        return $this->votes->where('vote','down')->count();
    }
    public function incrementReadCount() {
        $this->views++;
        return $this->save();
    }

    public function scopeOrderByVoteCount($query)
    {
        return $query->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
                     ->select('posts.*', DB::raw('count(votes.id) as vote_count'))
                     ->groupBy('posts.id')
                     ->orderBy('vote_count', 'desc');
    }

    public function isWithinPostClosureDate()
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

    public function sendEmailNotificationToQACoordinator()
    {
        if($this->author->department)
        {
            $department = $this->author->department;
    
            if($department->getQACoordinator())
            {
                $qaCoordinator = $department->getQACoordinator();
            }
        
            if ($qaCoordinator) {
                $qaCoordinator->notify(new PostCreatedNotification($this));
            }
        }
    }
    protected static function booted()
    {
        static::creating(function ($post) {
            if (!$post->isWithinPostClosureDate()) {
                return false; // Prevent post creation if outside closure date
            }

            $post->sendEmailNotificationToQACoordinator();
        });
    }

    public function isWithinCommentClosureDate()
    {
        $closureDate = ClosureDate::where('academic_year', date('Y'))->first();

        if(!$closureDate) {
            return true;
        }
        if ($closureDate) {
            $commentClosureDate = $closureDate->comment_end_date;

            if (carbon::now()->lte($commentClosureDate)) {
                return true;
            }
        }

        return false;
    }
    
}
