@extends('layouts.dashboard')

@section('content')
<x-client-sidebar />
<main class="flex-grow p-6 container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8" id="readings">
        <!-- Current readings will be injected here via JavaScript -->
    </div>

    <section class="bg-white p-8 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-green-600">Temperature & Weight Fluctuations 📈</h3>
        <canvas id="fluctuationChart" class="mt-4"></canvas>
    </section>

    <section class="mt-8 bg-white p-8 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-green-600">Recent Hive Readings</h3>
        <div class="mt-4">
            <table class="min-w-full bg-gray-100" id="recentReadings">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="w-1/4 px-4 py-2">Time</th>
                        <th class="w-1/4 px-4 py-2">Temperature</th>
                        <th class="w-1/4 px-4 py-2">Humidity</th>
                        <th class="w-1/4 px-4 py-2">Weight (kg)</th>
                        <th class="w-1/4 px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $reading)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($reading['created_at'])->format('h:i A')
                            }}</td>
                        <td class="border px-4 py-2">{{ $reading['temperature'] }}°C</td>
                        <td class="border px-4 py-2">{{ $reading['humidity'] }}%</td>
                        <td class="border px-4 py-2">{{ $reading['weight'] / 1000 }}kg</td>
                        <td
                            class="border px-4 py-2 {{ $reading['temperature'] > 36 ? 'text-red-500' : 'text-green-500' }}">
                            {{ $reading['temperature'] > 36 ? 'Alert' : 'Normal' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const ctx = document.getElementById('fluctuationChart').getContext('2d');
    let fluctuationChart;

    function updateData() {
        $.get('/api/latest-readings', function(data) {
            const latestReading = data[0];

            $('#readings').html(`
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold text-green-600 text-center">Current Temperature 🌡️</h2>
                    <div class="flex justify-center items-center mt-4">
                        <div class="text-5xl font-bold text-green-700 pulse">${latestReading.temperature}°C</div>
                    </div>
                    <p class="text-center text-gray-500 mt-2">Optimal range: 32°C - 36°C</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold text-green-600 text-center">Current Humidity 💧</h2>
                    <div class="flex justify-center items-center mt-4">
                        <div class="text-5xl font-bold text-blue-700 pulse">${latestReading.humidity}%</div>
                    </div>
                    <p class="text-center text-gray-500 mt-2">Optimal range: 50% - 60%</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold text-green-600 text-center">Current Hive Weight 🏋️‍♂️</h2>
                    <div class="flex justify-center items-center mt-4">
                        <div class="text-5xl font-bold text-orange-700 pulse">${(latestReading.weight / 1000).toFixed(2)}kg</div>
                    </div>
                    <p class="text-center text-gray-500 mt-2">Target weight: 1kg - 10kg</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold text-green-600 text-center">Alerts 🚨</h2>
                    <ul class="list-disc list-inside mt-4 text-red-500">
                        ${latestReading.temperature > 36 ? '<li>⚠️ Temperature exceeds 36°C</li>' : ''}
                        ${latestReading.humidity < 50 ? '<li>⚠️ Humidity below 50%</li>' : ''}
                        ${latestReading.weight < 1000 ? '<li>⚠️ Weight dropped below 1kg</li>' : ''}
                    </ul>
                </div>
            `);

            $('#recentReadings tbody').html(data.map((reading, index) => `
                <tr class="${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'}">
                    <td class="border px-4 py-2">${new Date(reading.created_at).toLocaleTimeString()}</td>
                    <td class="border px-4 py-2">${reading.temperature}°C</td>
                    <td class="border px-4 py-2">${reading.humidity}%</td>
                    <td class="border px-4 py-2">${(reading.weight / 1000).toFixed(2)}kg</td>
                    <td class="border px-4 py-2 ${reading.temperature > 36 ? 'text-red-500' : 'text-green-500'}">
                        ${reading.temperature > 36 ? 'Alert' : 'Normal'}
                    </td>
                </tr>
            `).join(''));

            const labels = data.map(reading => new Date(reading.created_at).toLocaleTimeString());
            const temperatures = data.map(reading => reading.temperature);
            const weights = data.map(reading => reading.weight / 1000);

            if (fluctuationChart) {
                fluctuationChart.destroy();
            }

            fluctuationChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Temperature (°C)',
                            data: temperatures,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                        },
                        {
                            label: 'Weight (kg)',
                            data: weights,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                        }
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Value'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        }
                    }
                }
            });
        });
    }

    updateData();
    setInterval(updateData, 1000);
</script>
@stop