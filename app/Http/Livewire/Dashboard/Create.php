<?php

namespace App\Http\Livewire\Dashboard;

use Closure;
use DateTime;
use Filament\Forms;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class Create extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;  

    public $title;
    public $slug;
    public $content;
    public $category_id;
    public $published_at;
    public $isAnnonyous=false;
    public $display_name;
    public $agree=false;

    public function mount()
    {
        $this->form->fill();
    }    
    
    protected function updatedIsAnnonyous()
    {
        if($this->isAnnonyous)
        {
            $this->display_name="Annonyous";
        }
        elseif(!$this->isAnnonyous)
        {
            $id = Auth::user()->id;
            $currentuser = User::find($id);
            $this->display_name=$currentuser->name;
        }
    }
    protected function getFormSchema(): array
    {
        return [
           Grid::make()->schema([        

                TextInput::make('title')
                    ->reactive()
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(function (TextInput $component,Closure $set, $state) {
                        $set('slug', Str::slug($state));
                        $component->state(ucwords($state));
                    }),

                TextInput::make('slug')
                    ->disabled()
                    ->required()
                    ->unique(Post::class, 'slug', ignoreRecord: true),
                    
                
                Forms\Components\MarkdownEditor::make('content')
                ->required()
                ->columnSpan('full'),

                Forms\Components\Select::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name','id'))
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
           ]),

        ];
    }
        protected function getFormModel(): string 
        {
            return Post::class;
        }
    public function submit()
    {
        if($this->isAnnonyous)
        {
            $this->display_name="Annonyous";
        }
        elseif(!$this->isAnnonyous)
        {
            $id = Auth::user()->id;
            $currentuser = User::find($id);
            $this->display_name=$currentuser->name;
        }
        
        Post::create(
            array_merge($this->form->getState(),[
                'user_id' => auth()->user()->id,
                'display_name' =>$this->display_name
                ])
        );

        Notification::make()
        ->title('Saved successfully')
        ->icon('heroicon-o-document-text') 
        ->iconColor('success') 
        ->send();
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.dashboard.create');
    }
}
