<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\LineChartWidget;
use Filament\Widgets\BarChartWidget;

class VoteChart extends BarChartWidget
{
    public static function canView(): bool
    {
        $user=Auth::user();
        return $user->isQAM || $user->isAdmin;
    }
    protected static ?string $heading = 'Ideas votes report';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '400px';
    protected function getData(): array
    {

        $posts = Post::withCount(['votes as upvotes_count' => function ($query) {
            $query->where('vote', 'up');
        }, 'votes as downvotes_count' => function ($query) {
            $query->where('vote', 'down');
        }])->get();
        return [
            'datasets' => [
                [
                    'label' => 'Upvotes',
                    'data' => $posts->pluck('upvotes_count')->toArray(),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Downvotes',
                    'data' => $posts->pluck('downvotes_count')->toArray(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $posts->pluck('title')->map(function($title){
                return Str::of($title)->words(1);
            })->toArray(),
        ];
    }
}
