<?php

namespace App\Jobs;

use App\Models\UsemeJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PostOfferToUsemeJob implements ShouldQueue
{
    use Queueable;

    public $usemeJob;
    private const DEFAULT_PAYMENT = 2000;


    public function __construct(
        $usemeJob
    ) {
        $this->usemeJob = $usemeJob;
    }

    public function handle(): void
    {
        $usemeJob = UsemeJob::findOrFail($this->usemeJob);

        $usemeId = $this->extractJobId($usemeJob->job_url);

        $formUrl = "https://useme.com/pl/jobs/{$usemeId}/post-offer/";
        
        $token = $this->scrapeCsrfToken($formUrl);

        $payment = $this->extractPaymentAmount($usemeJob->proposal_generated);
        
        // Prepare form data
        $formData = [
            'csrfmiddlewaretoken' => $token,
            'copyright_transfer' => 'protocol',
            'description' => $this->decodeUnicodeString(substr($usemeJob->proposal_generated, 1, -1)),
            'payment' => $payment,
            'currency' => 'PLN',
            'work_days' => '30',
            'billing_calculator' => 'GROSS',
            'license_duration' => '15',
            'stages-TOTAL_FORMS' => '5',
            'stages-INITIAL_FORMS' => '0',
            'stages-MIN_NUM_FORMS' => '0',
            'stages-MAX_NUM_FORMS' => '1000'
        ];

        // Add empty stage fields
        for ($i = 0; $i < 5; $i++) {
            $formData["stages-{$i}-id"] = '';
            $formData["stages-{$i}-name"] = '';
            $formData["stages-{$i}-description"] = '';
            $formData["stages-{$i}-payment"] = '';
            $formData["stages-{$i}-work_days"] = '';
        }

        // Send POST request with exact headers from your request
        $response = Http::asForm()
            ->withHeaders([
                'authority' => 'useme.com',
                'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'accept-encoding' => 'gzip, deflate, br, zstd',
                'accept-language' => 'pl-PL,pl;q=0.9,en-US;q=0.8,en;q=0.7',
                'cache-control' => 'max-age=0',
                'origin' => 'https://useme.com',
                'referer' => $formUrl,
                'sec-ch-ua' => '"Google Chrome";v="129", "Not=A?Brand";v="8", "Chromium";v="129"',
                'sec-ch-ua-mobile' => '?0',
                'sec-ch-ua-platform' => '"macOS"',
                'sec-fetch-dest' => 'document',
                'sec-fetch-mode' => 'navigate',
                'sec-fetch-site' => 'cross-site',
                'sec-fetch-user' => '?1',
                'upgrade-insecure-requests' => '1',
                'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'Cookie' => $this->buildCookieString($token),
            ])
            ->post($formUrl, $formData);

        if ($response->successful()) {
            $redirectUrl = $response->header('location');
            if ($redirectUrl) {
                logger()->info('Offer posted successfully. Redirect URL:', ['url' => $redirectUrl]);
            }
            
            $messages = $response->header('set-cookie');
            logger()->info('Response cookies:', ['cookies' => $messages]);
            
        } else {
            logger()->error('Failed to post offer', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to post offer: ' . $response->status());
        }
    }

    /**
     * Extract payment amount from the proposal text
     * 
     * @param string $proposal
     * @return int
     */
    private function extractPaymentAmount(string $proposal): int 
    {
        // Remove any possible Unicode escapes first
        $decodedProposal = $this->decodeUnicodeString(substr($proposal, 1, -1));
        
        // Match patterns like "1000 PLN", "1,000 PLN", "1 000 PLN"
        if (preg_match('/(\d+(?:[ ,]\d+)*)\s*PLN/i', $decodedProposal, $matches)) {
            // Remove spaces and commas from the number
            $amount = (int) preg_replace('/[^\d]/', '', $matches[1]);
            
            // Validate the amount
            if ($amount > 0) {
                return $amount;
            }
        }
        
        // Log warning if no valid amount found
        logger()->warning('No valid PLN amount found in proposal, using default', [
            'proposal' => $decodedProposal,
            'default_amount' => self::DEFAULT_PAYMENT
        ]);
        
        return self::DEFAULT_PAYMENT;
    }

    /**
     * Build cookie string with exact cookies from your session
     */
    private function buildCookieString($csrfToken): string
    {
        return implode('; ', [
            '__hs_cookie_cat_pref=1:true_2:true_3:true',
            '_gcl_au=1.1.1673802465.1725194893',
            'hubspotutk=86bedd297b633165aec8f9759993a888',
            '__hssrc=1',
            '_fbp=fb.1.1725194893397.344509652865234829',
            '_ga=GA1.1.1503568793.1725194894',
            '_gcl_aw=GCL.1725194894.CjwKCAjwodC2BhAHEiwAE67hJOc2UENB8ubefRgTgQVo1NkzLUb89-8rOEhoiKFACTi4eqVVsdswXxoCyGoQAvD_BwE',
            '_gcl_gs=2.1.k1$i1725194894',
            '_hjSessionUser_661614=eyJpZCI6ImU0NjczNWRkLTk5MjctNTVjNC1hYWZiLTE0MjJiM2NhZGU3ZSIsImNyZWF0ZWQiOjE3MjUxOTQ4OTQ1NjIsImV4aXN0aW5nIjp0cnVlfQ==',
            'csrftoken=' . $csrfToken,  // Update with the latest CSRF token
            'sessionid=hm57m0jp20mgrkul7dqlgtcbjzrpmba3',   // Update with the latest session ID
            'user_id=219122',
            '_hjSession_661614=eyJpZCI6ImRkZWU3NTBmLWYxMmEtNGYyMi1iZDM3LWU1NmI2YzZlNzQzZiIsImMiOjE3MzAwMjcxNzQ0ODUsInMiOjAsInIiOjAsInNiIjowLCJzciI6MCwic2UiOjEsImZzIjowLCJzcCI6MH0=',
            '__hstc=194865778.86bedd297b633165aec8f9759993a888.1725194891709.1730018976346.1730027179974.249',
            '_ga_3MHM4HVMF1=GS1.1.1730027179.257.1.1730029388.55.0.0',
            '__hssc=194865778.22.1730027179974'
        ]);
    }

    private function extractJobId($url)
    {
        if (preg_match('/,(\d+)\//', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function scrapeCsrfToken($url)
    {
        $html = file_get_contents($url);
        if (preg_match('/name="csrfmiddlewaretoken" value="([^"]+)"/', $html, $matches)) {
            return $matches[1];
        }
        return null;
    }

    function decodeUnicodeString($string) {
        return json_decode('"' . str_replace('"', '\\"', $string) . '"');
    }
}