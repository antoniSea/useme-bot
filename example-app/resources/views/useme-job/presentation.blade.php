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
            --primary: #4a90e2;
            --secondary: #5a67d8;
            --accent: #f6ad55;
            --text: #2d3748;
            --background: #f7fafc;
            --card-bg: #ffffff;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem 0;
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
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            z-index: 1;
        }
        .nav-links {
            display: flex;
            gap: 1rem;
            z-index: 1;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .nav-links a:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .hero {
            text-align: center;
            padding: 4rem 0;
            z-index: 1;
            position: relative;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .subtitle {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }
        .author-info {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-top: -3rem;
            z-index: 2;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .author-details {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .author-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .author-text h2 {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }
        .author-text p {
            color: var(--primary);
        }
        .contact-info a {
            color: var(--primary);
            text-decoration: none;
            display: block;
            margin-top: 0.5rem;
        }
        .main-content {
            padding: 4rem 0;
        }
        .grid {
            display: grid;
            gap: 2rem;
        }
        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        .card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .card h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .card h3 i {
            font-size: 1.2em;
        }
        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .timeline {
            position: relative;
            padding-left: 2rem;
            margin-top: 2rem;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
        }
        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
            padding-left: 1.5rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 0.5rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background-color: var(--primary);
        }
        .timeline-item h4 {
            margin-bottom: 0.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .timeline-item p {
            color: var(--text);
            opacity: 0.8;
        }
        .chart-container {
            height: 300px;
            margin-top: 2rem;
        }
        .testimonial {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 2rem;
            margin-top: 4rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .testimonial-text {
            font-style: italic;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            position: relative;
        }
        .testimonial-text::before,
        .testimonial-text::after {
            content: '"';
            font-size: 3rem;
            color: var(--accent);
            position: absolute;
            opacity: 0.3;
        }
        .testimonial-text::before {
            top: -1rem;
            left: -1rem;
        }
        .testimonial-text::after {
            bottom: -2rem;
            right: -1rem;
        }
        .testimonial-author {
            font-weight: 600;
            color: var(--primary);
        }
        .cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-align: center;
            padding: 4rem 0;
            margin-top: 4rem;
            border-radius: 10px;
        }
        .cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .cta-button {
            display: inline-block;
            background-color: var(--accent);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .cta-button:hover {
            background-color: #f59e0b;
            transform: translateY(-2px);
        }
        footer {
            background-color: var(--text);
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .container {
                width: 100%;
            }
            .card, .author-info, .timeline-item, .testimonial, .cta {
                break-inside: avoid;
            }
        }
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .author-info {
                flex-direction: column;
                text-align: center;
            }
            .contact-info {
                margin-top: 1rem;
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
                <h1>{{ $data['project_title'] ?? 'Projekt Automatyzacji Procesów' }}</h1>
                <p class="subtitle">{{ $data['project_subtitle'] ?? 'Innowacyjne rozwiązania dostosowane do Twoich unikalnych potrzeb biznesowych' }}</p>
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
                <a href="tel:576 205 389"><i class="fas fa-phone" style="margin-right: 5px"></i>+48 576 205 389</a>
                <a href="mailto:a.seba@soft-synergy.com"><i class="fas fa-envelope" style="margin-right: 5px"></i>a.seba@soft-synergy.com</a>
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
                <h3><i class="fas fa-lightbulb"></i> Innowacje i technologie</h3>
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
                <p class="testimonial-text">{{ $data['testimonial']->text }}</p>
                <p class="testimonial-author">- {{ $data['testimonial']->author }}</p>
            </div>

            <!-- CTA Section -->
            <div class="cta" data-aos="fade-up">
                <h2>{{ $data['cta']->title }}</h2>
                <p>{{ $data['cta']->description }}</p>
                <a href="https://softsynergy.youcanbook.me/" class="cta-button" target="_blank">
                    <i class="fas fa-calendar-check"></i> {{ $data['cta']->button_text }}
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

    <!-- Scripts -->
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
                    title: '{{ $data['project_title'] }}',
                    url: window.location.href
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch(console.error);
            } else {
                alert('Funkcja udostępniania nie jest dostępna w tej przeglądarce.');
            }
        }

        // Chart Initialization
        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data['progress']->labels) !!},
                datasets: [{
                    label: 'Czas wykonania (dni)',
                    data: {{ json_encode($data['progress']->data) }},
                    backgroundColor: 'rgba(74, 144, 226, 0.7)',
                    borderColor: 'rgba(74, 144, 226, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, max: 100 }
                },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>