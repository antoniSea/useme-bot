<?php

namespace App\Observers;

use App\Models\UsemeJob;
use App\Services\ProposalGeneratorService;

class UsemeJobObserver
{
    public function created(UsemeJob $model)
    {
        dd('okej');
        $model->proposal_generated = app(ProposalGeneratorService::class)
            ->generateProposal($model);
    }   
}
