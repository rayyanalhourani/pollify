<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="">
                    <img class="h-12 w-12" src='/images/logos/logo2cut.png'
                        alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="/"
                            class="rounded-md px-3 py-2 text-sm font-medium <?= urlIs("/") ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white"; ?>">Home</a>
                        <a href="/voting"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 <?= urlIs("/voting") ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white"; ?>">Voting</a>
                        <a href="/about"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 <?= urlIs("/about") ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white"; ?>">About</a>
                        <a href="/contact"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 <?= urlIs("/contact") ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white"; ?>">Contact</a>
                        <?php if ($_SESSION["user"]["role"]=="admin") : ?>
                            <a href="/polls"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 <?= urlIs("/polls") ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white"; ?>">Polls</a>
                            <a href="/users"
                                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 <?= urlIs("/users") ? "bg-gray-900 text-white" : "text-gray-300 hover:bg-gray-700 hover:text-white"; ?>">Users</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <?php if (isset($_SESSION['user']["email"])): ?>
                        <button type="button"
                            class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="mt-1 px-2 flex items-center">
                        <?php if (isset($_SESSION['user']["email"])): ?>
                            <form action="/logout" method="post"><button
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign
                                    out</button></form>
                        <?php else: ?>
                            <a href="/login"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Login</a>

                            <a href="/signup"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign
                                up</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>