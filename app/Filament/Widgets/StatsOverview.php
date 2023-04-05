<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        $user=Auth::user();
        return $user->isQAM || $user->isAdmin;
    }
    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        $posts=Post::all();
       $acitveuser=Post::distinct('user_id')->count();
       $users=User::all()->count();
       $totalusers=' Total users : '. $users;
       return [
            Card::make('Total Views', $posts->sum('reads'))
                // ->description('32k increase')
                // ->descriptionIcon('heroicon-s-trending-up')
                // ->color('success'),
                ,
            Card::make('Total Posts', $posts->count())
                // ->description('7% increase')
                // ->descriptionIcon('heroicon-s-trending-down')
                // ->color('danger'),
                ,
            Card::make('Active users', $acitveuser)
                ->description($totalusers)
                // ->descriptionIcon('heroicon-s-trending-up')
                // ->color('success'),
        ];
    }
}
