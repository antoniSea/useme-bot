<?php

namespace App\Console\Commands;

use App\Services\UsemeScraperService;
use Illuminate\Console\Command;

class ScrapeUsemeJobs extends Command
{
    protected $signature = 'scrape:useme {pages=2}';
    protected $description = 'Scrape jobs from Useme website';

    public function handle(UsemeScraperService $scraperService)
    {
        $pages = $this->argument('pages');
        
        $this->info("Starting to scrape Useme jobs...");
        
        try {
            $scraperService->scrapeJobs($pages);
            $this->info("Successfully completed scraping jobs.");

            
    
        } catch (\Exception $e) {
            $this->error("Error occurred while scraping: " . $e->getMessage());
        }
    }
}
