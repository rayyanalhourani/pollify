<?php
require "../views/partials/header.view.php";
require "../views/partials/nav.view.php";
?>

<main>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class=" text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create new poll
    </div>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="/polls/create" method="POST">
            <div>
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                <div class="mt-2">
                    <input id="title" name="title" type="text" required
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="text-red-500 text-sm"><?= $errors["title"] ?? "" ?></div>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                <textarea
                    id="description"
                    name="description"
                    class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 placeholder:text-sm focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                    rows="4"
                    placeholder="Enter the description..."></textarea>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="startTime" class="block text-sm font-medium leading-6 text-gray-900">Start time</label>
                </div>
                <div class="mt-2">
                    <input id="startTime" name="startTime" type="datetime-local"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="text-red-500 text-sm"><?= $errors["startTime"] ?? "" ?></div>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="endTime" class="block text-sm font-medium leading-6 text-gray-900">End time</label>
                </div>
                <div class="mt-2">
                    <input id="endTime" name="endTime" type="datetime-local"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="text-red-500 text-sm"><?= $errors["endTime"] ?? "" ?></div>
            </div>
            <!-- options -->
            <div class="flex justify-center flex-col">
                <div class="flex justify-between items-center">
                    <h1 class="text-lg">Options</h1>
                    <button type="button" onclick="addOption()" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2">Add Option</button>
                </div>

                <div id="options">

                </div>
            </div>
            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create poll</button>
            </div>
        </form>
    </div>
    </div>
</main>

<script>
    let numOfOptions = 1

    function addOption() {

        let option = `<div class="mt-2 flex justify-between items-center" id="option_${numOfOptions}">
                        <input name="options[]" type="text" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                        <svg class="w-6 h-6 text-red-800 cursor-pointer" onclick="deleteOption(${numOfOptions})" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                        </svg>
                    </div>`

        numOfOptions++
        document.getElementById("options").innerHTML += option
    }

    function deleteOption(id) {
        document.getElementById("option_"+id).remove();
    }
    
</script>
<?php require "../views/partials/footer.view.php"; ?>