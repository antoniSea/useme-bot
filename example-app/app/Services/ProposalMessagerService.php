<?php

namespace App\Services;

use App\Jobs\PostOfferToUsemeJob;
use App\Models\UsemeJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class ProposalMessagerService
{
  public function check(): array
  {
      try {
        $formUrl = 'https://useme.com/pl/mesg/compose/105309/208532/';
        
            $token = $this->scrapeCsrfToken($formUrl);

          $response = Http::withHeaders([
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
        ->post($formUrl, [
            'csrfmiddlewaretoken' => $token,
            'content' => "Dziękuję za zapytanie. Jako Project Manager w Soft Synergy specjalizujemy się właśnie w obsłudze i rozwoju stron WordPress - od drobnych poprawek po kompleksowe projekty. Proponuję następujące rozwiązanie: Pakiet 5h/tydzień w cenie 400 PLN netto Gwarantowany czas reakcji do 24h Pełne wsparcie zespołu specjalistów (front-end, back-end) Comiesięczny raport z wykonanych prac Pierwsza godzina wsparcia gratis - dla weryfikacji jakości naszych usług Proszę o informację, jakiego rodzaju poprawki są potrzebne? Pozwoli to precyzyjniej określić zakres wsparcia. Zachęcam do zapoznania się z naszymi realizacjami na stronie soft-synergy.com. Jestem do dyspozycji pod numerem +48 576 205 389 lub mailowo: info@soft-synergy.com. Z poważaniem, Antoni Seba Project Manager Soft Synergy",
            // 'g-recaptcha-response' => '03AFcWeA5Xa8Uq9QdEgb3-L1Fgd3nMYDcdQz4ep1Paqg3xNCO9tLwp3ARj0Zw8iP5Q0nnmD4fF7UGFbF_m_Fv6gxM_AvQe10_mykeuvVZeevvFAWj2SH_VS3weBWCDOo6dKMhpTiixLZPVWWGIgnLB9QNJBp8Km3iyggqYdL2GyUzXc5NFro4y1z2SzFSpmcr3bMfk69CUcsZqd-rLS7BDQcNUT1HT8Q5GZjFKVmFLegLDVVc6oQfz09iNjwTLevjNsVvvsosgCdFw5pwe1z5-LvrUWlPPbUuc73YxtL0wJ0Fk3daU4rqHjks87u5PcX5tE0H9MbfReMk64W-90WDiRS6R2hi5dQyXqVuGW3vLLim2V0nKWpe3JjecGC9zEMYYocCfuVY2xPSIEeVhYRvp6MWdCtApBAhD2DLWvZRTxL6fq8QKChzsgy4akYgfj1XQppmgMAnWCJuN0sqh31x-YK1E5oS_i7sUY8N9TQjChP3JbGAWydu3nm2kBUDs851tnu-SXxV9pAzAQotkVRQgwV9elbLX4AfFcXRyQ37WZRwVeV82nUnldqQHAyj7HOWi5X9elN10igwuEQN5jNmJCznluWBNv5GoYtkFNoBLrLmL0kvh8ZZn75NjTU0SeefJeRGMtXoDpvnNedIhqm0iRV52glSG1ytxNkPrbp2a7elC1oH1S8bd_WY7xw7v9-qwV6zuRHV6GBwa7fOl4OMdUTgnIj7WYezxgGNCOuxnJI2DbtooMBw9cj7A10wBJZf8K7w2kAvqH1vn1-TvqCsY4UbZjuMybuNeL3ZA-vrS2dsSAET1IiQS_RnwoJLTd0zLOsb2uPhmBg6-fWy6PjlqhhyHe_HI8iKxo1z5MJMFmy33xkde2L_NUi1BvHc1MkBXMv5BgPeJCTMnkEaQCjbDzNgBXvYVr7neulmy2HS6SzVOFC51Qy_MBBg',
            'files-TOTAL_FORMS' =>  1,
            'files-INITIAL_FORMS' => 0,
            'files-MIN_NUM_FORMS' => 0,
            'files-MAX_NUM_FORMS' => 1000
        ]);

          return [
              'status' => $response->status(),
              'body' => $response->body(),
          ];

      } catch (\Exception $e) {
          return [
              'status' => 404,
              'error' => $e->getMessage()
          ];
      }
  }

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
        'csrftoken=' . $csrfToken,
        'sessionid=ih11rlnqbtoh8mkiiol5s258o074q1hv',
        'user_id=219122',
        '_hjSession_661614=eyJpZCI6ImRkZWU3NTBmLWYxMmEtNGYyMi1iZDM3LWU1NmI2YzZlNzQzZiIsImMiOjE3MzAwMjcxNzQ0ODUsInMiOjAsInIiOjAsInNiIjowLCJzciI6MCwic2UiOjEsImZzIjowLCJzcCI6MH0=',
        '__hstc=194865778.86bedd297b633165aec8f9759993a888.1725194891709.1730018976346.1730027179974.249',
        '_ga_3MHM4HVMF1=GS1.1.1730027179.257.1.1730029388.55.0.0',
        '__hssc=194865778.22.1730027179974'
    ]);
}

private function scrapeCsrfToken($url)
{
    $html = file_get_contents($url);
    dd($html);
    if (preg_match('/name="csrfmiddlewaretoken" value="([^"]+)"/', $html, $matches)) {
        return $matches[1];
    }
    return null;
}
}