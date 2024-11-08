<?php
require "../views/partials/header.view.php";
require "../views/partials/nav.view.php";
?>

<main>

    <div class="flex min-h-full flex-col justify-center px-6">
        <div class="">
            <img class="mx-auto h-52 w-52 w-auto" src="/images/logos/logo1.png"
                alt="Your Company">
            <h2 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create new account
            </h2>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-4" action="/signup" method="POST">
                <div>
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full name</label>
                    <div class="mt-2">
                        <input id="name" name="name" type="name" autocomplete="name" value="<?= old('name') ?>" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-red-500 text-sm"><?= $errors["name"] ?? "" ?></div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" value="<?= old('email') ?>" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-red-500 text-sm"><?= $errors["email"] ?? "" ?></div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-red-500 text-sm"><?= $errors["password"] ?? "" ?></div>

                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="cpassword" class="block text-sm font-medium leading-6 text-gray-900">Confirm
                            Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="cpassword" name="cpassword" type="password" autocomplete="current-password" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-red-500 text-sm"><?= $errors["cpassword"] ?? "" ?></div>
                </div>
                <div class="flex items-center flex-col justify-center gap-2">
                    <div>
                        <label for="captcha" class="block text-md font-medium leading-6 text-gray-900">Enter CAPTCHA:</label>
                    </div>
                    <img src="/images/captcha/<?=$_SESSION['captcha']['id']?>.png" class="border border-black" alt="CAPTCHA Image">
                    <div class="mt-2">
                        <input id="captcha" name="captcha" type="text" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-red-500 text-sm"><?= $errors["captcha"] ?? "" ?></div>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign
                        in</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Already have account?
                <a href="/login" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign in</a>
            </p>
        </div>
    </div>

</main>
<?php require "../views/partials/footer.view.php"; ?>