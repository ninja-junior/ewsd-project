<?php

namespace App\Http\Livewire\Posts;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;
use function Pest\Laravel\get;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    
    public $search='';
    public $choose='title';
    protected $queryString = ['search','choose'];
    public $userId ;
    public $currentuser ;
    public $content;
    public $isAnnonyous =false;
    public $display_name;

    public $userVote;
    public $totalUpVote=null;
    public $totalDownVote=null;

    protected $rules = [
        'content' => 'required',
    ];
    protected $listeners = [
        'voteUp' => 'voteUp',
        'voteDown'=>'voteDown',
    ];
    public function mount()
    {
        // dd($this->queryCategory); 
        
        $this->userId = Auth::user()->id;
        $this->currentuser = User::find($this->userId);   
        
  
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function read(Post $post)
    {
        $post->incrementReadCount();
      
    }

    # Comment section
    public function submitComment(int $id)
    {
        $post=Post::findOrFail($id);
        if($this->isAnnonyous)
        {
            $this->display_name="Annonyous";
            
        }
        elseif(!$this->isAnnonyous)
        {            
            $this->display_name=$this->currentuser->name;
        }

        $this->validate();

        $post->comments()->create([
            'user_id' => $this->userId,
            'display_name' => $this->display_name,
            'content' => $this->content,
        ]);

        // redirect()->route('posts.index');
    }

    public function delete($commentId)
    {
        try{
            Comment::find($commentId)->delete();
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong!!");
        }
        // redirect()->route('posts.index');
    }

#end comment section

#vote section
public function vote($type,$id )
    {
        $this->userVote = Vote::where('user_id', auth()->id())
            ->where('post_id', $id)
            ->value('vote');
        
        if ($this->userVote == $type) {
            Vote::where('user_id', auth()->id())
                ->where('post_id', $id)
                ->delete();
                $this->userVote = null; 
                                
        } else {
            Vote::updateOrCreate(
                ['user_id' => auth()->id(), 'post_id' => $id],
                ['vote' => $type]
            );
            $this->userVote = $type; 
          
        }  
       
        // redirect()->route('posts.index');
  

            // $this->totalDownVote=$this->post->totalDownVote();
            // $this->totalUpVote=$this->post->totalUpVote();
        
       
        
    }
#end vote section
public function updatingSearch()
{
    $this->resetPage();
}
    public function render()
    {   
   
            if($this->choose=='mostvote')
            {
                $posts = Post::join('votes', 'posts.id', '=', 'votes.post_id')
                    ->select('posts.*', DB::raw('SUM(CASE WHEN votes.vote = "up" THEN 1 ELSE 0 END) as up_votes'))
                    ->whereDate('published_at', '<=', Carbon::now()->toDateString())
                    ->groupBy('posts.id')
                    ->orderByDesc('up_votes')
                    ->latest()
                    ->paginate(5);
                // dd($posts);
            }
            else{

                $posts = Post::with(['comments','votes'])                
                ->when($this->choose == 'title', function ($q) {
                    return $q->where('title', 'LIKE', '%' . $this->search . '%');
                })
                ->when($this->choose == 'content', function ($q) {
                    return $q->where('content', 'LIKE', '%' . $this->search . '%');
                })
                ->when($this->choose == 'author', function ($q) {
                    $q->where('display_name', 'LIKE', '%' . $this->search . '%');
                    
                } )
                ->when($this->choose == 'mostview', function ($q) {
                    $q->orderby('views', 'DESC');                
                } )
                
                ->when($this->choose == 'category', function ($q) {
                    return $q->whereHas('category', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->search . '%');
                    });
                })
                     
                ->whereDate('published_at', '<=', Carbon::now()->toDateString())
                ->latest()
                ->paginate(5);            
            }

            return view('livewire.posts.index', compact('posts'));
    }
}
