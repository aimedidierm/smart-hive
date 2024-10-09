<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smart Hive Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-100 text-gray-800">

    <header class="bg-green-600 p-4 text-white text-center">
        <h1 class="text-4xl font-bold">🐝 Smart Hive - Your Beekeeping Companion 🐝</h1>
        <p class="mt-2 text-lg">Optimize and monitor your hive conditions with ease</p>
    </header>

    <section class="flex flex-col items-center justify-center text-center py-10">
        <h2 class="text-3xl font-semibold text-green-700">Welcome to Smart Hive! 🍯</h2>
        <p class="mt-4 text-xl">Keep your bees happy, healthy, and productive with real-time insights 🌍</p>
        <a href="#features"
            class="mt-6 px-6 py-3 bg-green-500 text-white font-bold rounded-lg shadow hover:bg-green-700">
            Explore Features
        </a>
    </section>

    <section id="features" class="py-16 bg-green-50">
        <div class="container mx-auto">
            <h3 class="text-2xl text-center font-semibold text-green-700">Key Features 🛠️</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">

                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">Real-Time Monitoring 📊</h4>
                    <p class="mt-4">Track temperature, humidity, and other hive conditions in real-time.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">Data-Driven Insights 📈</h4>
                    <p class="mt-4">Get valuable insights to optimize hive performance and bee health.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">Hive Alerts 🚨</h4>
                    <p class="mt-4">Receive instant alerts if your hive's conditions go out of the safe range.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-green-100">
        <div class="container mx-auto">
            <h3 class="text-2xl text-center font-semibold text-green-700">Beekeeping Tips 🐝</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">Tip #1: Keep Your Bees Hydrated 💧</h4>
                    <p class="mt-4">Ensure your bees have access to clean water, especially during hot weather.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">Tip #2: Regular Hive Inspections 🔍</h4>
                    <p class="mt-4">Inspect your hives regularly for signs of pests, diseases, or any issues.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">Tip #3: Plant Bee-Friendly Flowers 🌻</h4>
                    <p class="mt-4">Help your bees by planting flowers that are rich in nectar and pollen.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">Tip #4: Maintain Hive Cleanliness 🧹</h4>
                    <p class="mt-4">Keep the area around your hives clean to minimize the risk of diseases.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="sales" class="py-16 bg-green-50">
        <div class="container mx-auto">
            <h3 class="text-2xl text-center font-semibold text-green-700">Available Sales</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                @foreach ($sales as $sale)
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h4 class="text-xl font-bold text-green-600">{{ $sale->amount }} Rwf</h4>
                    <p class="mt-4">{{ $sale->title }}</p>
                    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        onclick="document.getElementById('requestModal-{{ $sale->id }}').classList.remove('hidden')">
                        Submit Request
                    </button>

                    <!-- Modal -->
                    <div id="requestModal-{{ $sale->id }}"
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                        <div class="bg-white rounded-lg p-6 w-96">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-lg font-bold">Submit Request for {{ $sale->title }}</h5>
                                <button class="text-gray-500 hover:text-gray-700"
                                    onclick="document.getElementById('requestModal-{{ $sale->id }}').classList.add('hidden')">
                                    &times;
                                </button>
                            </div>
                            <form action="{{ route('orderRequest') }}" method="POST">
                                @csrf
                                <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                                <div class="mb-4">
                                    <label for="names" class="block text-sm font-medium text-gray-700">
                                        Names</label>
                                    <input class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="names"
                                        type="text" name="names" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">
                                        phone</label>
                                    <input class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" id="phone"
                                        type="number" name="phone" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="requestDetails" class="block text-sm font-medium text-gray-700">More
                                        Details</label>
                                    <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        id="requestDetails" name="request_details" rows="3"></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 bg-green-700 text-white text-center">
        <h3 class="text-3xl font-semibold">Get Started with Smart Hive Today! 🏠</h3>
        <p class="mt-4 text-xl">Join a community of beekeepers making hive management smarter and easier.</p>
        <br>
        <a href="/login" class="mt-6 px-6 py-3 bg-white text-green-700 font-bold rounded-lg shadow hover:bg-gray-200">
            Sign in
        </a>
    </section>

    <footer class="bg-green-800 p-6 text-white text-center">
        <p>&copy; 2024 Smart Hive. All Rights Reserved. | Designed for Beekeepers with ❤️</p>
    </footer>

</body>

</html>