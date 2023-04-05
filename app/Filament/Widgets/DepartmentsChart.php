<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\BarChartWidget;
use Illuminate\Support\Facades\Auth;

class DepartmentsChart extends BarChartWidget
{
    public static function canView(): bool
    {
        $user=Auth::user();
        return $user->isQAM || $user->isAdmin;
    }
    protected static ?string $heading = 'Idea per department report';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $postsPerDepartment=DB::table('posts')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->join('departments', 'users.department_id', '=', 'departments.id')
        ->select('departments.name',DB::raw('count(posts.id) as post_count'))
        ->groupBy('departments.name')
        ->get()
        ->toArray();
        $usersPerDepartment=DB::table('users')
        ->join('departments', 'users.department_id', '=', 'departments.id')
        ->select('departments.name',DB::raw('count(users.id) as user_count'))
        ->groupBy('departments.name')
        ->get()
        ->toArray();
        // $depts=Arr::pluck($postsPerDepartment,'name');
        // dd($depts);
        return [
            'datasets' => [
              [
                    'label' => 'Number of posts',
                    'data' => Arr::pluck($postsPerDepartment,'post_count'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
              ],
              [
                    'label' => 'Number of users',
                    'data' => Arr::pluck($usersPerDepartment,'user_count'),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
              ]

            ],
            'labels' => Arr::pluck($postsPerDepartment,'name'),
        ];
    }
}
