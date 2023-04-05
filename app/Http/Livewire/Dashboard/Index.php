<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Post;
use Filament\Tables;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Index extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable; 
    public $isClosureDate=null;

    public function mount()
    {
        $this->isClosureDate=Auth::user()->isClosureDate();
    }
    protected function getTableQuery(): Builder 
    {
        return Post::query()->where('user_id',auth()->id());
    } 
    protected function getTableRecordsPerPageSelectOptions(): array 
    {
        return [5];
    } 
    public function render()
    {       
        
      
        return view('livewire.dashboard.index');
    }

    public function createPage()
    {
        return redirect()->route('dashboard.create');
    }

    protected function getTableColumns(): array 
    {
        return [ 
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('author.name'),
        ]; 
    }
    protected function getTableActions(): array
    {
        return [ 
            Tables\Actions\Action::make('edit')
                ->url(fn (Post $record): string => route('dashboard.update', $record))
                ->visible(fn (Post $record): bool => auth()->user()->can('update', $record)),
                Tables\Actions\Action::make('delete')
                ->action(fn (Post $record) => $record->delete())
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->visible(fn (Post $record): bool => auth()->user()->can('delete', $record)),
        ]; 
    }
    protected function getTableBulkActions(): array
    {
        return [ 
            Tables\Actions\BulkAction::make('delete')
                ->label('Delete selected')
                ->color('danger')
                ->action(function (Collection $records): void {
                    $records->each->delete();
                })
                ->requiresConfirmation(),
        ]; 
    } 
    public function deletePost($id)
    {
        try{
            Post::find($id)->delete();
            session()->flash('success',"Post Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong!!");
        }
    }
}
