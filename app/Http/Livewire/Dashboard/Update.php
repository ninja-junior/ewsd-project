<?php

namespace App\Http\Livewire\Dashboard;

use Closure;
use Filament\Forms;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class Update extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;  
    public Post $post;

    public $title;
    public $slug;
    public $content;
    public $category_id;
    public $published_at;
    public $image;

    public function mount(): void
    {       
        // dd($this->post->image)       ; 
        $this->form->fill([
            'title' => $this->post->title,
            'slug' => $this->post->slug,
            'content' => $this->post->content,
            'concategory_id' => $this->post->category_id,
            'published_at'=>$this->post->published_at,
            'image'=>$this->post->image

        ]);
    }

    protected function getFormSchema(): array
    {
        return [
           Grid::make()->schema([
                TextInput::make('title')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));}),
                    

                TextInput::make('slug')
                    ->disabled()
                    ->required()
                    ->unique(Post::class, 'slug', ignoreRecord: true),
                    
                
                Forms\Components\MarkdownEditor::make('content')
                ->required()
                ->columnSpan('full'),

                Forms\Components\Select::make('category_id')
                ->label('Category')
                ->relationship('category','name')
                ->required(),

                Forms\Components\DatePicker::make('published_at')
                ->label('Published Date'),

                Forms\Components\Section::make('Image')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->directory('images')
                        ->disableLabel(),
                ])
                ->collapsible(),
            Forms\Components\Placeholder::make('created_at')
                ->label('Created at')
                ->content(fn (Post $record): ?string => $record->created_at?->diffForHumans()),

            Forms\Components\Placeholder::make('updated_at')
                ->label('Last modified at')
                ->content(fn (Post $record): ?string => $record->updated_at?->diffForHumans()),
           ]),

        ];
    }

    protected function getFormModel(): Post 
    {
        return $this->post;
    } 

    public function submit()
    {
        try {
            Post::whereId($this->post->id)->update(
                array_merge($this->form->getState(),['user_id' => auth()->user()->id])
            );
    
            Notification::make()
            ->title('update successfully')
            ->icon('heroicon-o-document-text') 
            ->iconColor('success') 
            ->send();
        }catch (\Exception $ex) {
            Notification::make()
            ->title('error')
            ->icon('heroicon-o-document-text') 
            ->iconColor('success') 
            ->send();
        }
   
        
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.dashboard.update');
    }
}
