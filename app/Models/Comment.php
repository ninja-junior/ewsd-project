<?php

namespace App\Models;

use App\Notifications\PostCommented;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory,Notifiable;
    protected $guarded=[];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function getPostOwner()
    {
        return $this->post->author;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected function isWithinClosureDate()
    {
        $closureDate = ClosureDate::where('academic_year', date('Y'))->first();

        if(!$closureDate) {
            return true;
        }
        if ($closureDate) {
            $commentClosureDate = $closureDate->comment_end_date;

            if (now()->lte($commentClosureDate)) {
                return true;
            }
        }

        return false;
    }

    public function sendEmailNotificationToPostOwner()
    {
        $postOwner = $this->getPostOwner();

        if ($postOwner) {
            $data = [
                'post_id' => $this->post_id,
                'postTitle' => $this->post->title,
                'commentBy' => $this->display_name,
            ];
            $postOwner->notify(new PostCommented($data));
        }
    }

    protected static function booted()
    {
        static::creating(function ($comment) {
            if (!$comment->isWithinClosureDate()) {
                return false; // Prevent comment creation if outside closure date
                // dd('reaching fale comment');
            }
            $comment->sendEmailNotificationToPostOwner();
        });
    }
}
