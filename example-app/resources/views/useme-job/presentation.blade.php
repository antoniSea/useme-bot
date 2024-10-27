

<script src="https://cdn.tailwindcss.com/3.4.5"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">


<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100">
    <!-- Navbar -->
    <nav class="bg-white bg-opacity-70 backdrop-blur-lg border-b border-blue-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">
                        Soft Synergy
                    </div>
                    <div class="h-6 w-px bg-blue-200"></div>
                    <div class="text-blue-700 text-sm">Centrum innowacji w automatyzacji</div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-blue-600">Przygotował CTO</p>
                        <p class="text-lg font-semibold text-gray-800">Antoni Seba</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-xl font-bold text-white">
                        AS
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-white bg-opacity-50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="animate__animated animate__fadeIn">
                <h1 class="text-4xl font-bold mb-2 bg-gradient-to-r from-blue-700 to-indigo-700 text-transparent bg-clip-text">
                    {{ $projectInfo->title }}
                </h1>
                <p class="text-gray-700 text-lg max-w-2xl">
                    {{ $projectInfo->description }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach($keyMetrics as $metric)
            <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-xl border border-blue-200 p-6 transform hover:scale-105 transition-all animate__animated animate__fadeInUp shadow-lg" @if(!$loop->first) style="animation-delay: {{ $loop->index * 0.1 }}s" @endif>
                <h3 class="text-blue-600 text-sm font-medium">{{ $metric->title }}</h3>
                <p class="text-3xl font-bold mt-2 bg-gradient-to-r from-blue-700 to-indigo-700 text-transparent bg-clip-text">{{ $metric->value }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $metric->subtitle }}</p>
            </div>
            @endforeach
        </div>

        <!-- Timeline and Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Gantt Chart -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-xl border border-blue-200 p-6 animate__animated animate__fadeInLeft shadow-lg">
                <h2 class="text-xl font-semibold mb-6 bg-gradient-to-r from-blue-700 to-indigo-700 text-transparent bg-clip-text">
                    Harmonogram realizacji
                </h2>
                <canvas id="ganttChart" class="w-full"></canvas>
            </div>

            <!-- Detailed Timeline -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-xl border border-blue-200 p-6 animate__animated animate__fadeInRight shadow-lg">
                <h2 class="text-xl font-semibold mb-6 bg-gradient-to-r from-blue-700 to-indigo-700 text-transparent bg-clip-text">
                    Szczegółowy plan projektu
                </h2>
                <div class="space-y-4">
                    @foreach($projectPhases as $phase)
                    <div class="relative pl-8 {{ !$loop->last ? 'before:absolute before:left-0 before:h-full before:w-px before:bg-gradient-to-b before:from-blue-500 before:to-indigo-500' : '' }}">
                        <div class="absolute left-0 top-1 h-4 w-4 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 transform -translate-x-1.5"></div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $phase->title }}</h3>
                        <p class="text-blue-600 mt-1">{{ $phase->period }} • {{ $phase->budget }} PLN</p>
                        <p class="text-sm text-gray-600 mt-2">{{ $phase->description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Additional Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Team -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-xl border border-blue-200 p-6 animate__animated animate__fadeInUp shadow-lg">
                <h2 class="text-xl font-semibold mb-6 bg-gradient-to-r from-blue-700 to-indigo-700 text-transparent bg-clip-text">
                    Zespół projektowy
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($teams as $team)
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="font-semibold text-gray-800">{{ $team->name }}</h3>
                        <ul class="mt-2 space-y-1 text-sm text-gray-600">
                            @foreach((array)$team->members as $member)
                            <li>{{ $member }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Innovation & Technology -->
            <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-xl border border-blue-200 p-6 animate__animated animate__fadeInUp shadow-lg">
                <h2 class="text-xl font-semibold mb-6 bg-gradient-to-r from-blue-700 to-indigo-700 text-transparent bg-clip-text">
                    Innowacje i technologie
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach((array)$technology as $tech)
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="font-semibold text-gray-800">{{ $tech->name }}</h3>
                        <ul class="mt-2 space-y-1 text-sm text-gray-600">
                            @foreach((array)$tech->items as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ganttChart').getContext('2d');
    const ganttChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($ganttChart->labels),
            datasets: [{
                label: 'Czas trwania (miesiące)',
                data: @json($ganttChart->data),
                backgroundColor: @json($ganttChart->backgroundColor),
                borderColor: @json($ganttChart->borderColor),
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Czas trwania: ${context.raw} dni`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Czas trwania (dni)'
                    },
                    ticks: {
                        stepSize: 0.5
                    },
                    max: 8
                }
            }
        }
    });
});
</script>
