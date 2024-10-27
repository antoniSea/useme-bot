<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsemeJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'avatar_url',
        'offers_count',
        'time_remaining',
        'title',
        'job_url',
        'preview_description',
        'full_description',
        'category',
        'category_url',
        'budget',
        'page',
        'proposal_generated',
    ];

    public function getProposalString(): string
    {
        return 'Tytuł: ' . $this->title . ' Opis: ' . $this->preview_description;
    }
}