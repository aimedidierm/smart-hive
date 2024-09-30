@extends('layouts.dashboard')

@section('content')
<x-admin-sidebar />
<main class="flex-grow p-6 container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-green-600 text-center">Current Temperature 🌡️</h2>
            <div class="flex justify-center items-center mt-4">
                <div class="text-5xl font-bold text-green-700 pulse">34°C</div>
            </div>
            <p class="text-center text-gray-500 mt-2">Optimal range: 32°C - 36°C</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-green-600 text-center">Current Humidity 💧</h2>
            <div class="flex justify-center items-center mt-4">
                <div class="text-5xl font-bold text-blue-700 pulse">55%</div>
            </div>
            <p class="text-center text-gray-500 mt-2">Optimal range: 50% - 60%</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-green-600 text-center">Current Hive Weight 🏋️‍♂️</h2>
            <div class="flex justify-center items-center mt-4">
                <div class="text-5xl font-bold text-orange-700 pulse">15kg</div>
            </div>
            <p class="text-center text-gray-500 mt-2">Target weight: 12kg - 20kg</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-green-600 text-center">Alerts 🚨</h2>
            <ul class="list-disc list-inside mt-4 text-red-500">
                <li>⚠️ Temperature exceeds 36°C</li>
                <li>⚠️ Humidity below 50%</li>
                <li>⚠️ Weight dropped below 12kg</li>
            </ul>
        </div>
    </div>

    <section class="bg-white p-8 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-green-600">Temperature & Weight Fluctuations 📈</h3>
        <div class="w-full h-64 bg-green-100 mt-4 relative">

            <div class="absolute w-2 h-10 bg-red-500 top-20 left-1/4 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-red-500 top-24 left-1/3 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-red-500 top-28 left-1/2 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-red-500 top-22 left-3/4 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-red-500 top-26 left-2/3 rounded-full temp-fluctuate"></div>


            <div class="absolute w-2 h-10 bg-orange-500 top-40 left-1/4 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-orange-500 top-38 left-1/3 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-orange-500 top-35 left-1/2 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-orange-500 top-37 left-3/4 rounded-full temp-fluctuate"></div>
            <div class="absolute w-2 h-10 bg-orange-500 top-39 left-2/3 rounded-full temp-fluctuate"></div>

            <div class="absolute bottom-0 left-0 w-full text-center py-4 text-gray-500">Time ⏰</div>
            <div class="absolute bottom-0 right-0 w-full text-center py-4 text-gray-500">Temp & Weight</div>
        </div>
    </section>

    <section class="mt-8 bg-white p-8 rounded-lg shadow-md">
        <h3 class="text-2xl font-semibold text-green-600">Recent Hive Readings</h3>
        <div class="mt-4">
            <table class="min-w-full bg-gray-100">
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
                    <tr class="bg-gray-50">
                        <td class="border px-4 py-2">12:00 PM</td>
                        <td class="border px-4 py-2">35°C</td>
                        <td class="border px-4 py-2">56%</td>
                        <td class="border px-4 py-2">15kg</td>
                        <td class="border px-4 py-2 text-green-500">Normal</td>
                    </tr>
                    <tr class="bg-white">
                        <td class="border px-4 py-2">12:30 PM</td>
                        <td class="border px-4 py-2">37°C</td>
                        <td class="border px-4 py-2">52%</td>
                        <td class="border px-4 py-2">14kg</td>
                        <td class="border px-4 py-2 text-red-500">Alert</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="border px-4 py-2">1:00 PM</td>
                        <td class="border px-4 py-2">34°C</td>
                        <td class="border px-4 py-2">54%</td>
                        <td class="border px-4 py-2">15kg</td>
                        <td class="border px-4 py-2 text-green-500">Normal</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
@stop