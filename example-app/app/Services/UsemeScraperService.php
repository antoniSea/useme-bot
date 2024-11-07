<?php


namespace App\Services;

use App\Jobs\PostOfferToUsemeJob;
use App\Models\UsemeJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class UsemeScraperService
{
    protected $headers = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Language' => 'en-US,en;q=0.5',
        'Referer' => 'https://useme.com/',
        'DNT' => '1',
        'Connection' => 'keep-alive',
        'Upgrade-Insecure-Requests' => '1',
    ];

    /**
     * List of allowed categories
     */
    protected $allowedCategories = [
        'SEO',
        'Aplikacje mobilne',
        'Sklepy internetowe',
        'Projektowanie UX/UI',
        'Strony internetowe',
        'Bazy danych',
        'Kampanie reklamowe',
        'Grafika 2D',
        'Aplikacje webowe',
        'Oprogramowanie',
        'Obsługa stron internetowych',
        'Analityka internetowa',
        'Wprowadzanie danych',
        'Social media'
    ];
    /**
     * Check if job category is allowed
     */
    protected function isAllowedCategory(string $category): bool
    {
        return in_array(trim($category), $this->allowedCategories, true);
    }

    /**
     * Extract Useme ID from job URL
     */
    protected function extractUsemeId(string $url): ?int
    {
        if (preg_match('/,(\d+)\/?$/', $url, $matches)) {
            return (int) $matches[1];
        }
        return null;
    }

    /**
     * Scrape full job description from individual job page
     */
    protected function getFullJobDescription(string $jobUrl): string
    {
        try {
            // Add delay to prevent rate limiting
            sleep(rand(1, 2));

            $response = Http::withHeaders($this->headers)->get($jobUrl);
            
            if (!$response->successful()) {
                Log::error("Failed to fetch job details from: " . $jobUrl);
                return 'Description not found';
            }

            $crawler = new Crawler($response->body());
            
            // Find and extract the full description
            $description = $crawler->filter('.job-details__description')->each(function (Crawler $node) {
                return $node->text();
            });

            return $description[0] ?? 'Description not found';

        } catch (\Exception $e) {
            Log::error("Error getting full job description from {$jobUrl}: " . $e->getMessage());
            return 'Error retrieving description';
        }
    }

    /**
     * Extract skills from job listing
     */
    protected function extractSkills(Crawler $node): array
    {
        try {
            return $node->filter('.job__skills .skill')->each(function (Crawler $skillNode) {
                return trim($skillNode->text());
            });
        } catch (\Exception $e) {
            Log::error("Error extracting skills: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Scrape jobs from a single page
     */
    protected function scrapePage(int $pageNumber): array
    {
        $url = "https://useme.com/pl/jobs/?page=" . $pageNumber;
        $jobsData = [];

        try {
            // Add delay between page requests
            sleep(rand(2, 4));

            $response = Http::withHeaders($this->headers)->get($url);
            
            if (!$response->successful()) {
                Log::error("Failed to fetch page {$pageNumber}");
                return [];
            }

            $crawler = new Crawler($response->body());
            
            $crawler->filter('article.job')->each(function (Crawler $node) use (&$jobsData, $pageNumber) {
                try {
                    // Extract category first to check if we should process this job
                    $categoryElement = $node->filter('.job__category a p');
                    $category = $categoryElement->count() > 0 ? trim($categoryElement->text()) : 'N/A';

                    // Skip if category is not in our allowed list
                    if (!$this->isAllowedCategory($category)) {
                        return;
                    }

                    // Extract username
                    $username = $node->filter('strong')->count() > 0 
                        ? $node->filter('strong')->text()
                        : 'N/A';

                    // Extract avatar URL
                    $avatarUrl = $node->filter('img.user-avatar__image')->count() > 0
                        ? $node->filter('img.user-avatar__image')->attr('src') ?? $node->filter('img.user-avatar__image')->attr('data-src')
                        : 'N/A';

                    // Extract offers count
                    $offersCount = $node->filter('.job__header-details--offers span')->count() > 0
                        ? $node->filter('.job__header-details--offers span')->text()
                        : 'N/A';

                    // Extract time remaining
                    $timeRemaining = $node->filter('.job__header-details--date span')->count() > 0
                        ? $node->filter('.job__header-details--date span')->last()->text()
                        : 'N/A';

                    // Extract title and URL
                    $titleElement = $node->filter('a.job__title');
                    $title = $titleElement->count() > 0 ? $titleElement->text() : 'N/A';
                    $jobUrl = $titleElement->count() > 0 
                        ? 'https://useme.com' . $titleElement->attr('href')
                        : 'N/A';

                    // Extract Useme ID from URL
                    $usemeId = $jobUrl !== 'N/A' ? $this->extractUsemeId($jobUrl) : null;

                    // Get full description if we have a valid URL
                    $fullDescription = $jobUrl !== 'N/A' 
                        ? $this->getFullJobDescription($jobUrl)
                        : 'N/A';

                    // Extract preview description
                    $previewDesc = $node->filter('p.mb-0')->count() > 0
                        ? $node->filter('p.mb-0')->text()
                        : 'N/A';

                    $categoryUrl = $categoryElement->count() > 0
                        ? 'https://useme.com' . $node->filter('.job__category a')->attr('href')
                        : 'N/A';

                    // Extract budget
                    $budget = $node->filter('.job__budget .job__budget-value')->count() > 0
                        ? $node->filter('.job__budget .job__budget-value')->text()
                        : 'N/A';

                    // Extract skills
                    $skills = $this->extractSkills($node);

                    $jobsData[] = [
                        'useme_id' => $usemeId,
                        'username' => $username,
                        'avatar_url' => $avatarUrl,
                        'offers_count' => $offersCount,
                        'time_remaining' => $timeRemaining,
                        'title' => $title,
                        'job_url' => $jobUrl,
                        'preview_description' => $previewDesc,
                        'full_description' => $fullDescription,
                        'category' => $category,
                        'category_url' => $categoryUrl,
                        'budget' => $budget,
                        'skills' => $skills,
                        'page' => $pageNumber
                    ];

                    Log::info("Successfully scraped job: " . $title . " (ID: " . $usemeId . ")");

                } catch (\Exception $e) {
                    Log::error("Error parsing job on page {$pageNumber}: " . $e->getMessage());
                }
            });

            return $jobsData;

        } catch (\Exception $e) {
            Log::error("Error scraping page {$pageNumber}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Main method to scrape multiple pages
     */
    public function scrapeJobs(int $numPages = 5): void
    {
        for ($page = 1; $page <= $numPages; $page++) {
            Log::info("Scraping page {$page}...");
    
            $jobsData = $this->scrapePage($page);
    
            if (!empty($jobsData)) {
                // Store jobs in database
                foreach ($jobsData as $jobData) {
                    try {
                        // Convert skills array to JSON string for storage
                        $jobData['skills'] = json_encode($jobData['skills'] ?? [], JSON_UNESCAPED_UNICODE);
            
                        // Use both useme_id and job_url as unique identifiers
                        $usemeJob = UsemeJob::updateOrCreate(
                            [
                                'job_url' => $jobData['job_url'],
                                'useme_id' => $jobData['useme_id']
                            ],
                            $jobData
                        );
            
                        if ($usemeJob->wasRecentlyCreated) {
                            $proposal = app(ProposalGeneratorService::class)->generateProposal($usemeJob);
                            $usemeJob->proposal_generated = $proposal;
                            $usemeJob->save();

                            dispatch(new PostOfferToUsemeJob($usemeJob->id))->delay(now()->addHour());

                            Log::info("Proposal generated successfully for model ID {$usemeJob->id}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error storing job: " . $e->getMessage(), [
                            'job_url' => $jobData['job_url'] ?? 'N/A',
                            'useme_id' => $jobData['useme_id'] ?? 'N/A'
                        ]);
                        continue; // Skip this job and continue with the next one
                    }
                }
            
                Log::info("Successfully scraped " . count($jobsData) . " jobs from page {$page}");
            }            
        }
    }
}