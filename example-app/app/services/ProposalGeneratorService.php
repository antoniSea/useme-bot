<?php

namespace App\Services;

use App\Helpers\ClauteHelper;
use App\Models\UsemeJob;

class ProposalGeneratorService
{
  public function __construct(private ClauteHelper $clauteHelper) {}

  public function generateProposal(UsemeJob $job)
  {
    $jobString = $job->getProposalString();
    $firstPrompt = "Jesteś project menagerem (Antoni Seba) w Soft synergy (software house). Będziesz otrzymywał zapytania ofertowe z serwisu useme i będziesz musiał przygotować ofertę wycenę, timeline etc odpowiadaj w zależności od stylu zapytania jeśli jest potoczne jeśli profesjonalnie to profesjonalnie  to odpowiadaj potocznie zawsze podpisuj się. i oferuj usługi firmy soft synergy używaj wiadomości z najlepszych książek sprzedażowych musisz sprzedać jak najwięcej zawsze dodawaj numer telefonu i email +48 576 205 389 [info@soft-synergy.com](mailto:info@soft-synergy.com) wywżyj wrażenie na kliencie że nasza firma przysiadła i opracowała naprade dobry plan pamiętaj żeby skupić się na dobrze klienta kluczową częścią jest zdobycie uwagi klienta na początku. Klient musi być przekonany o wyjątakowego  nie lej wody nad wyraz zachowaj rzeczowy punkt zaproponuj bardziej szczegółowe rozwiązania. Pokaż że znasz się na danym temacie. dodaj stronę internetową soft-synergy.com !! Pamiętaj że to ty jesteś menagerem i że musisz przeprowadzić wycenę sam !! !! Zawsze odpowiadaj wiadomością bezpośrednio do klienta bez niczego do wypełnienia !! !! Nie przynoś wstydu - wiadomości generowane przez ciebie będą wklejane bezpośrednio do konwersacji z klientem w imieniu Pana Antoniego Seby!! Zakres prac – dokładnie opisz, co zrobisz dla klienta. Informacje o doświadczeniu – pochwal się swoimi umiejętnościami i wcześniejszymi projektami. Stawka – jasno określ, ile będzie kosztować Twoja praca. Rada Useme: klienci najchętniej wybierają oferty z dobrym stosunkiem jakości do ceny, i nie zawsze są to najtańsze propozycje. Czas wykonania – podaj realny termin realizacji projektu. całość napisz maksymalnie zwięźle i pewnie siebie.

    Formaty: Zawsze cenę podawaj w PLN a czas w dniach. Przykład: 2000 PLN 30 dni. Pamiętaj, żeby nie podawać cen w godzinach, ani nie podawać cen za słowo. Wszystkie oferty, które nie będą spełniały tych wymagań, będą odrzucane. Pamiętak aby cena była na przykład 1000 PLN nie nic innego np 1000 zł nie wchodzi w gre tak samo nie 1000PLN

    Ceny to powinno być około 60% ceny którą faktycznie wziął by software house za takie zlecenie. Mamy tanią siłę roboczą

    dodaj informację ze przygotowaliśmy równiez raport w formie wizualnej prezentacji dodaj link do prezentacji w https://prezentacje.soft-synergy.com/{slug} gdzie slug to nazwa projektu w formie sluga np. dla projektu Strona internetowa dla firmy slug to strona-internetowa-dla-firmy przeprowadz pełną wycenę a o prezentacji na stronie tylko wspomnij
    ";
    $response = $this->clauteHelper->sendMessage($jobString . $firstPrompt);
    $this->generatePresentation($job, $response);


// Regular expression to match the desired slug pattern
$pattern = '/https:\/\/prezentacje\.soft-synergy\.com\/([a-zA-Z0-9-_]+)/';

// Use preg_match_all to find all matches in the text
preg_match_all($pattern, $response['content'][0]['text'], $matches);

// Check if any matches were found
if (!empty($matches[1])) { // Change from $matches[0] to $matches[1]
    // Store the matched slugs in the additional_website_data property
    $job->additional_website_data = implode(', ', $matches[1]); // Use $matches[1] to get slugs
} else {
    // If no matches were found, you can set it to null or an empty string
    $job->additional_website_data = null; // or ''
}

// Save the job object
$job->save();


    return json_encode($response['content'][0]['text']);
  }

  5ab332c1c41a6 sql_prezentacje_soft_synergy_com

  public function generatePresentation (UsemeJob $job, $response)
  {
    $prompt = 'to jest propozycja projektu: ' . $response['content'][0]['text'] . '


    przygotuj prezentację w formie json identycznej w formacie do tej poniżej Adekwatnej do projektu. pamiętaj o tym aby wszystko było po polsku i zgodne z projektem. 
    {
  "projectInfo": {
    "title": "Project Vision 2025",
    "description": "Transformacja cyfrowa nowej generacji z wykorzystaniem najnowszych technologii i metodyk zarządzania projektami."
  },
  "keyMetrics": [
    {
      "title": "Czas realizacji",
      "value": "6 miesięcy",
      "subtitle": "Q4 2024 - Q2 2025"
    },
    {
      "title": "Budżet",
      "value": "350,000 PLN",
      "subtitle": "Optymalizacja kosztów"
    },
    {
      "title": "Zespół",
      "value": "8 ekspertów",
      "subtitle": "Dedykowany zespół"
    },
    {
      "title": "Kamienie milowe",
      "value": "5 etapów",
      "subtitle": "Precyzyjne planowanie"
    }
  ],
  "projectPhases": [
    {
      "title": "Faza 1: Analiza i planowanie",
      "period": "Grudzień 2024",
      "budget": "45,000",
      "description": "Kompleksowa analiza wymagań, architektura systemu, planowanie UX"
    },
    {
      "title": "Faza 2: Design i prototypowanie",
      "period": "Styczeń-Luty 2025",
      "budget": "65,000",
      "description": "UI/UX design, interaktywne prototypy, user testing"
    },
    {
      "title": "Faza 3: Development",
      "period": "Luty-Kwiecień 2025",
      "budget": "120,000",
      "description": "Full-stack development, integracje, optymalizacja"
    },
    {
      "title": "Faza 4: Testy i QA",
      "period": "Kwiecień-Maj 2025",
      "budget": "70,000",
      "description": "Testing, QA, optymalizacja wydajności"
    },
    {
      "title": "Faza 5: Wdrożenie",
      "period": "Maj 2025",
      "budget": "50,000",
      "description": "Deployment, dokumentacja, szkolenia"
    }
  ],
  "teams": [
    {
      "name": "Development Team",
      "members": [
        "3 Senior Developers",
        "2 Frontend Specialists",
        "1 Database Expert"
      ]
    },
    {
      "name": "Support Team",
      "members": [
        "1 UX/UI Designer",
        "1 QA Engineer",
        "1 Business Analyst"
      ]
    }
  ],
  "technology": [
    {
      "name": "Stack technologiczny",
      "items": [
        "Next.js & React",
        "Node.js & Express",
        "PostgreSQL & Redis"
      ]
    },
    {
      "name": "Metodyka",
      "items": [
        "Agile & Scrum",
        "CI/CD Pipeline",
        "Cloud-Native"
      ]
    }
  ],
  "ganttChart": {
    "labels": ["Analiza i planowanie", "Design i prototypowanie", "Rozwój MVP", "Testy i QA", "Wdrożenie"],
    "data": [1, 1.5, 2, 1, 0.5],
    "backgroundColor": [
      "rgba(54, 162, 235, 0.8)",
      "rgba(75, 192, 192, 0.8)",
      "rgba(153, 102, 255, 0.8)",
      "rgba(255, 159, 64, 0.8)",
      "rgba(255, 99, 132, 0.8)"
    ],
    "borderColor": [
      "rgba(54, 162, 235, 1)",
      "rgba(75, 192, 192, 1)",
      "rgba(153, 102, 255, 1)",
      "rgba(255, 159, 64, 1)",
      "rgba(255, 99, 132, 1)"
    ]
  }
}
 ';
 $response = $this->clauteHelper->sendMessage($prompt);


  $job->additional_indo =  str_replace( '\n', '', $response['content'][0]['text']);
  $job->save();
  }
}