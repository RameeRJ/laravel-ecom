<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome | ShopEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Vite for Tailwind CSS -->
    <style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 1s ease-out forwards;
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans">

    <div class="relative bg-gradient-to-br from-white to-gray-100 min-h-screen overflow-hidden">
        <!-- Header -->
        <header class="flex justify-between items-center px-6 py-4 shadow-md bg-white fixed w-full z-20">
            <h1 class="text-2xl font-bold text-indigo-600">ShopEase</h1>
            <nav>
                <a href="#" class="text-gray-700 hover:text-indigo-600 mx-3">About us</a>
                <a href="#" class="text-gray-700 hover:text-indigo-600 mx-3">Contact</a>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="flex flex-col md:flex-row items-center justify-between px-6 md:px-20 pt-32 pb-16 md:pb-32">
            <div class="max-w-xl animate-slide-up">
                <h2 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight text-gray-900">
                    Discover Quality Products<br> at Unbeatable Prices
                </h2>
                <p class="text-lg text-gray-600 mb-6">Shop the latest trends in electronics, fashion, home essentials
                    and more—all in one place.</p>
                <a href="{{ url('/products') }}"
                    class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-indigo-700 transition">
                    Explore Now
                </a>
                <a href="{{ route('login') }}"
                    class="inline-block border border-indigo-600 text-indigo-600 bg-white px-6 py-3 rounded-lg text-lg hover:bg-indigo-50 transition">
                    Login
                </a>
            </div>

            <div class="w-full md:w-1/2 mt-10 md:mt-0 animate-slide-up">
                <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?auto=format&fit=crop&w=800&q=80"
                    alt="Ecommerce" class="rounded-xl shadow-lg">

            </div>
        </section>

        <!-- Features Section (Optional) -->
        <section class="bg-white py-10 px-6 md:px-20">
            <h3 class="text-2xl font-bold mb-6 text-center">Why Shop With Us?</h3>
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <img src="https://img.icons8.com/color/96/shopping-cart-loaded.png" alt="Fast Cart"
                        class="mx-auto mb-4" />

                    <h4 class="font-semibold mb-2">Fast Delivery</h4>
                    <p class="text-gray-600">Lightning-fast shipping, always on time.</p>
                </div>
                <div>
                    <img src="https://img.icons8.com/color/96/discount.png" class="mx-auto mb-4" />
                    <h4 class="font-semibold mb-2">Great Discounts</h4>
                    <p class="text-gray-600">Save big with daily deals and offers.</p>
                </div>
                <div>
                    <img src="https://img.icons8.com/color/96/customer-support.png" class="mx-auto mb-4" />
                    <h4 class="font-semibold mb-2">24/7 Support</h4>
                    <p class="text-gray-600">We're always here to help you.</p>
                </div>
            </div>
        </section>
    </div>

</body>

</html>