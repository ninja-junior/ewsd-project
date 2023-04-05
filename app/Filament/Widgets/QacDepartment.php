<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use App\Models\Department;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\LineChartWidget;

class QacDepartment extends BarChartWidget
{
    

    public static function canView(): bool
    {
        $user=Auth::user();
        return  $user->isQAC;
    }

    protected static ?string $heading = "Department";

    protected function getData(): array
    {
        // $user=User::where('id',auth()->id())->where('d');
        $users=User::where('department_id',auth()->user()->department->id)->get();
        $data = [];

        foreach ($users as $user) {
            $postsCount = Post::where('user_id', $user->id)->count();
            $data[] = $postsCount;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Number of Posts',
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
