<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\UsemeJob;

class UsemeJob extends DataTableComponent
{
    protected $model = UsemeJob::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Avatar url", "avatar_url")
                ->sortable(),
            Column::make("Offers count", "offers_count")
                ->sortable(),
            Column::make("Time remaining", "time_remaining")
                ->sortable(),
            Column::make("Title", "title")
                ->sortable(),
            Column::make("Job url", "job_url")
                ->sortable(),
            Column::make("Preview description", "preview_description")
                ->sortable(),
            Column::make("Full description", "full_description")
                ->sortable(),
            Column::make("Category", "category")
                ->sortable(),
            Column::make("Category url", "category_url")
                ->sortable(),
            Column::make("Budget", "budget")
                ->sortable(),
            Column::make("Page", "page")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
