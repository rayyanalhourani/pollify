<?php
view("partials/header.view.php");
view("partials/nav.view.php");
view("partials/banner.view.php");
?>

<main>
    <div class="container flex flex-col px-6 py-10 mx-auto space-y-6 lg:h-[32rem] lg:py-16 lg:flex-row lg:items-center">
        <div class="w-full lg:w-1/2">
            <div class="lg:max-w-lg">
                <h1 class="text-3xl font-semibold tracking-wide text-gray-800 dark:text-white lg:text-4xl">
                    Secure and Simple Voting with Pollify
                </h1>
                <p class="mt-4 text-gray-600 dark:text-gray-300">
                    Empower your community to make decisions effortlessly with Pollify. A secure and user-friendly voting platform that makes every voice count.
                </p>
                <div class="grid gap-6 mt-8 sm:grid-cols-2">
                    <div class="flex items-center text-gray-800 dark:text-gray-200">
                        <svg class="w-5 h-5 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="mx-3">Easy Setup</span>
                    </div>

                    <div class="flex items-center text-gray-800 dark:text-gray-200">
                        <svg class="w-5 h-5 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="mx-3">Real-Time Results</span>
                    </div>

                    <div class="flex items-center text-gray-800 dark:text-gray-200">
                        <svg class="w-5 h-5 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="mx-3">Secure & Private Voting</span>
                    </div>

                    <div class="flex items-center text-gray-800 dark:text-gray-200">
                        <svg class="w-5 h-5 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="mx-3">Custom Poll Options</span>
                    </div>

                    <div class="flex items-center text-gray-800 dark:text-gray-200">
                        <svg class="w-5 h-5 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="mx-3">Transparent Voting Process</span>
                    </div>

                    <div class="flex items-center text-gray-800 dark:text-gray-200">
                        <svg class="w-5 h-5 mx-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="mx-3">Multi-Language Support</span>
                    </div>
                </div>

            </div>
            <div class="flex flex-col mt-6 space-y-3 lg:space-y-0 lg:flex-row">
                <a href="/voting" class="block px-5 py-2 text-sm font-medium tracking-wider text-center text-white transition-colors duration-300 transform bg-gray-900 rounded-md hover:bg-gray-700">Get Started</a>
                <a href="/about" class="block px-5 py-2 text-sm font-medium tracking-wider text-center text-gray-700 transition-colors duration-300 transform bg-gray-200 rounded-md lg:mx-4 hover:bg-gray-300">Learn More</a>
            </div>
        </div>

        <div class="flex items-center justify-center w-full h-96 lg:w-1/2">
            <img class="object-cover w-full h-full max-w-2xl rounded-md" src="images/logos/vote.png" alt="vote photo">
        </div>
    </div>
</main>

<?php view("partials/footer.view.php"); ?>