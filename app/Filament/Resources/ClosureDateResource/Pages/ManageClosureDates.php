<?php

namespace App\Filament\Resources\ClosureDateResource\Pages;

use App\Filament\Resources\ClosureDateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClosureDates extends ManageRecords
{
    protected static string $resource = ClosureDateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableRecordsPerPageSelectOptions(): array 
    {
        return [5];
    } 
}
