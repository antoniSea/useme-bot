<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soft Synergy - Prezentacja Projektu Automatyzacji</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --secondary: #6366f1;
            --accent: #f59e0b;
            --text: #1e293b;
            --text-light: #64748b;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
        }

        header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 10%, transparent 40%);
            transform: rotate(30deg);
            animation: gradient-shift 15s ease infinite;
        }

        @keyframes gradient-shift {
            0% { transform: rotate(30deg) translateY(0); }
            50% { transform: rotate(30deg) translateY(-10%); }
            100% { transform: rotate(30deg) translateY(0); }
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            position: relative;
            z-index: 2;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            background-color: rgba(255,255,255,0.1);
        }

        .nav-links a:hover {
            background-color: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .hero {
            text-align: center;
            padding: 6rem 0 8rem;
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 1.25rem;
            max-width: 700px;
            margin: 0 auto;
            color: rgba(255,255,255,0.9);
            font-weight: 400;
        }

        .author-info {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 2.5rem;
            margin-top: -4rem;
            z-index: 2;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
        }

        .author-details {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .author-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            font-weight: 600;
            box-shadow: var(--shadow);
        }

        .author-text h2 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            color: var(--text);
            font-weight: 600;
        }

        .author-text p {
            color: var(--primary);
            font-weight: 500;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .contact-info a {
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            background-color: var(--background);
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .contact-info a:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .contact-info i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .contact-info a:hover i {
            color: white;
        }

        .main-content {
            padding: 6rem 0;
        }

        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
            transition: all 0.3s ease;
            border: 1px solid var(--border);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .card h3 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card h3 i {
            font-size: 1.25em;
        }

        .metric-value {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .timeline {
            position: relative;
            padding-left: 2.5rem;
            margin-top: 2.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            border-radius: 3px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2.5rem;
            padding-left: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.25rem;
            top: 0.5rem;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            background-color: var(--primary);
            border: 3px solid var(--card-bg);
            box-shadow: var(--shadow);
        }

        .timeline-item h4 {
            margin-bottom: 0.75rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .timeline-item p {
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .chart-container {
            height: 350px;
            margin-top: 2.5rem;
        }

        .testimonial {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 3rem;
            margin-top: 5rem;
            text-align: center;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
        }

        .testimonial-text {
            font-style: italic;
            font-size: 1.25rem;
            margin-bottom: 2rem;
            position: relative;
            color: var(--text);
            line-height: 1.8;
        }

        .testimonial-text::before,
        .testimonial-text::after {
            content: '"';
            font-size: 4rem;
            color: var(--accent);
            position: absolute;
            opacity: 0.2;
            font-family: Georgia, serif;
        }

        .testimonial-text::before {
            top: -2rem;
            left: -1rem;
        }

        .testimonial-text::after {
            bottom: -3rem;
            right: -1rem;
        }

        .testimonial-author {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-align: center;
            padding: 5rem 2rem;
            margin-top: 5rem;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 40%, transparent 50%);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            position: relative;
        }

        .cta p {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background-color: white;
            color: var(--primary);
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        footer {
            background-color: var(--text);
            color: white;
            padding: 3rem 0;
            text-align: center;
            margin-top: 6rem;
        }

        footer p {
            opacity: 0.8;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            .container {
                width: 100%;
                padding: 0 2rem;
            }
            .card, .author-info, .timeline-item, .testimonial, .cta {
                break-inside: avoid;
                border: none;
                box-shadow: none;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            h1 {
                font-size: 2.5rem;
            }
            
            .author-info {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
            }
            
            .author-details {
                flex-direction: column;
                text-align: center;
            }
            
            .contact-info {
                width: 100%;
            }
            
            .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .card {
                padding: 2rem;
            }
            
            .timeline {
                padding-left: 2rem;
            }
        }
    </style>
</head>
<body>
 <!-- Header Section -->
<header class="no-print">
    <div class="container">
        <nav>
            <div class="logo">Soft Synergy</div>
            <div class="nav-links">
                <a href="#" onclick="window.print()"><i class="fas fa-print"></i> Drukuj</a>
                <a href="#" onclick="sharePage()"><i class="fas fa-share-alt"></i> Udostępnij</a>
                <a href="https://softsynergy.youcanbook.me/" target="_blank"><i class="fas fa-calendar-alt"></i> Umów spotkanie</a>
            </div>
        </nav>
        <div class="hero">
            <h1>{{ $data['project_title'] ?? 'Inteligentna Automatyzacja Procesów' }}</h1>
            <p class="subtitle">{{ $data['project_subtitle'] ?? 'Transformacja cyfrowa dostosowana do Twoich unikalnych potrzeb biznesowych' }}</p>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="container">
    <!-- Author Section -->
    <section class="author-info" data-aos="fade-up">
        <div class="author-details">
            <div class="author-avatar">AS</div>
            <div class="author-text">
                <h2>Antoni Seba</h2>
                <p>Menadżer ds. Oprogramowania</p>
            </div>
        </div>
        <div class="contact-info">
            <a href="tel:{{ $data['contact_phone'] ?? '576 205 389' }}"><i class="fas fa-phone"></i>+48 {{ $data['contact_phone'] ?? '576 205 389' }}</a>
            <a href="mailto:{{ $data['contact_email'] ?? 'a.seba@soft-synergy.com' }}"><i class="fas fa-envelope"></i>{{ $data['contact_email'] ?? 'a.seba@soft-synergy.com' }}</a>
        </div>
    </section>

    <!-- Project Metrics Section -->
    <section class="main-content">
        <div class="grid grid-4" data-aos="fade-up" data-aos-delay="200">
            @foreach ($data['metrics'] as $metric)
                <div class="card">
                    <h3><i class="{{ $metric->icon }}"></i> {{ $metric->title }}</h3>
                    <div class="metric-value">{{ $metric->value }}</div>
                    <p>{{ $metric->description }}</p>
                </div>
            @endforeach
        </div>

        <!-- Project Timeline and Progress Chart -->
        <div class="grid grid-2" style="margin-top: 4rem;">
            <div class="card" data-aos="fade-right">
                <h3><i class="fas fa-tasks"></i> Harmonogram projektu</h3>
                <div class="timeline">
                    @foreach ($data['timeline'] as $stage)
                        <div class="timeline-item">
                            <h4><i class="{{ $stage->icon }}"></i> {{ $stage->title }}</h4>
                            <p>{{ $stage->duration }} • {{ $stage->budget }}</p>
                            <p>{{ $stage->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card" data-aos="fade-left">
                <h3><i class="fas fa-chart-bar"></i> Postęp projektu</h3>
                <div class="chart-container">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Technologies Section -->
        <div class="card" style="margin-top: 4rem;" data-aos="fade-up">
            <h3><i class="fas fa-lightbulb"></i> Technologie i Innowacje</h3>
            <div class="grid grid-2">
                @foreach ($data['technologies'] as $techCategory)
                    <div>
                        <h4><i class="{{ $techCategory->icon }}"></i> {{ $techCategory->title }}</h4>
                        <ul>
                            @foreach ($techCategory->details as $detail)
                                <li>{{ $detail }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Testimonial Section -->
        <div class="testimonial" data-aos="fade-up">
            <p class="testimonial-text">{{ $data['testimonial']->text ?? 'Wdrożenie automatyzacji przez Soft Synergy przekroczyło nasze oczekiwania.' }}</p>
            <p class="testimonial-author">- {{ $data['testimonial']->author ?? 'Marek Kowalski, Dyrektor Operacyjny' }}</p>
        </div>

        <!-- CTA Section -->
        <div class="cta" data-aos="fade-up">
            <h2>{{ $data['cta']->title ?? 'Rozpocznij Transformację Cyfrową' }}</h2>
            <p>{{ $data['cta']->description ?? 'Umów bezpłatną konsultację i dowiedz się, jak możemy zoptymalizować procesy w Twojej firmie' }}</p>
            <a href="https://softsynergy.youcanbook.me/" class="cta-button" target="_blank">
                <i class="fas fa-calendar-check"></i> {{ $data['cta']->button_text ?? 'Zarezerwuj Spotkanie' }}
            </a>
        </div>
    </section>
</main>

<!-- Footer Section -->
<footer class="no-print">
    <div class="container">
        <p>&copy; {{ now()->year }} Soft Synergy. Wszelkie prawa zastrzeżone.</p>
    </div>
</footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        function sharePage() {
            if (navigator.share) {
                navigator.share({
                    title: 'Soft Synergy - Projekt Automatyzacji',
                    url: window.location.href
                }).then(() => {
                    console.log('Dziękujemy za udostępnienie!');
                }).catch(console.error);
            } else {
                alert('Funkcja udostępniania nie jest dostępna w tej przeglądarce.');
            }
        }

        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Analiza', 'Rozwój', 'Testy', 'Wdrożenie'],
                datasets: [{
                    label: 'Postęp (%)',
                    data: [100, 85, 60, 30],
                    backgroundColor: 'rgba(37, 99, 235, 0.7)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>