<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\BarChartWidget;

use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\Auth;

class UserActivityChart extends LineChartWidget
{
    public static function canView(): bool
    {
        $user=Auth::user();
        return $user->isQAM || $user->isAdmin;
    }
    protected static ?string $heading = 'User activity report';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
    
        $users = User::all();
        // $users = User::where('user_id', auth()->id())->get();
        $data = [];
    
        foreach ($users as $user) {
            $postsCount = Post::where('user_id', $user->id)->count();
            $data[] = $postsCount;
        }
        
        return [
            'datasets' => [

                [
                    'label' => 'Number of Ideas',
        
                    'data' => $data,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],

             ],
             'labels' => $users->pluck('name')->toArray(),
        ];
    }
}
