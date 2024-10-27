<?php

namespace App\Http\Controllers;

use App\Models\UsemeJob;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UsemeJobController extends Controller
{
    public function show(int $job): View
    {
        return view("useme-job.show", [
            'data' => UsemeJob::findOrFail($job)
        ]);
    }

    public function presentation(string $job): View
    {
        return view(
            'useme-job.presentation',
            get_object_vars(json_decode(UsemeJob::where('additional_website_data', $job)->firstOrFail()->additional_indo))
        );
    }
}
