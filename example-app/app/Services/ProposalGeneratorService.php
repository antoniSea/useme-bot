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


  public function generatePresentation (UsemeJob $job, $response)
  {
    $prompt = 'to jest propozycja projektu: ' . $response['content'][0]['text'] . '


    przygotuj prezentację w formie json identycznej w formacie do tej poniżej Adekwatnej do projektu. pamiętaj o tym aby wszystko było po polsku i zgodne z projektem. na wykresie jako data załącz czas wykonania etapu koniecznie w dniach wazne aby w kafelkach był końcowy koszt wyukonania całego projektu
    {
    "company": "Soft Synergy",
    "project_title": "Projekt Automatyzacji Procesów",
    "project_subtitle": "Innowacyjne rozwiązania dostosowane do Twoich unikalnych potrzeb biznesowych",
    "metrics": [
        {
            "icon": "fas fa-clock",
            "title": "Czas oszczędzony",
            "value": "250 godzin",
            "description": "Zredukowany czas operacyjny na powtarzalnych zadaniach."
        },
        {
            "icon": "fas fa-money-bill-wave",
            "title": "Oszczędności kosztów",
            "value": "50,000 PLN",
            "description": "Obniżenie kosztów operacyjnych w wyniku automatyzacji."
        },
        {
            "icon": "fas fa-user-check",
            "title": "Satysfakcja klientów",
            "value": "95%",
            "description": "Wzrost poziomu zadowolenia klientów po wdrożeniu rozwiązania."
        },
        {
            "icon": "fas fa-robot",
            "title": "Automatyzacja procesów",
            "value": "80%",
            "description": "Udział zautomatyzowanych procesów w całej organizacji."
        }
    ],
    "timeline": [
        {
            "icon": "fas fa-lightbulb",
            "title": "Analiza potrzeb",
            "duration": "1 miesiąc",
            "budget": "10,000 PLN",
            "description": "Analiza wymagań biznesowych i technologicznych klienta."
        },
        {
            "icon": "fas fa-code",
            "title": "Projektowanie rozwiązania",
            "duration": "2 miesiące",
            "budget": "20,000 PLN",
            "description": "Opracowanie architektury systemu oraz wstępnych prototypów."
        },
        {
            "icon": "fas fa-cogs",
            "title": "Implementacja",
            "duration": "3 miesiące",
            "budget": "50,000 PLN",
            "description": "Prace nad wdrożeniem rozwiązania oraz integracją z istniejącymi systemami."
        },
        {
            "icon": "fas fa-chart-line",
            "title": "Testowanie i optymalizacja",
            "duration": "1 miesiąc",
            "budget": "15,000 PLN",
            "description": "Sprawdzenie jakości, testy funkcjonalne oraz wprowadzenie optymalizacji."
        }
    ],
    "progress": {
        "labels": ["Analiza", "Projektowanie", "Implementacja", "Testowanie"],
        "data": [100, 100, 75, 50]
    },
    "technologies": [
        {
            "icon": "fas fa-brain",
            "title": "Sztuczna Inteligencja",
            "details": ["Machine Learning", "Przetwarzanie języka naturalnego", "Analiza predykcyjna"]
        },
        {
            "icon": "fas fa-database",
            "title": "Big Data",
            "details": ["Przechowywanie danych", "Analiza dużych zbiorów danych", "Optymalizacja wydajności"]
        }
    ],
    "testimonial": {
        "text": "Soft Synergy dostarczyło nam rozwiązanie, które znacząco poprawiło naszą efektywność i zadowolenie klientów.",
        "author": "Jan Kowalski, CEO ABC Corp"
    },
    "cta": {
        "title": "Gotowy na transformację?",
        "description": "Skontaktuj się z nami, aby dowiedzieć się więcej o możliwościach automatyzacji procesów.",
        "button_url": "https://soft-synergy.com/contact",
        "button_text": "Umów spotkanie"
    }
}
 ';
 $response = $this->clauteHelper->sendMessage($prompt);


  $job->additional_indo =  str_replace( '\n', '', $response['content'][0]['text']);
  $job->save();
  }
}