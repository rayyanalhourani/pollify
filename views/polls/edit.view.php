<?php
require "../views/partials/header.view.php";
require "../views/partials/nav.view.php";
?>

<main>
    <div class="flex min-h-full flex-col justify-center px-6 py-6 lg:px-8">
        <h2 class=" text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create new poll
    </div>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm pb-10">
        <form class="space-y-5 " action="/polls/update" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?= $poll["id"] ?>">
            <div>
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
                <div class="mt-2">
                    <input id="title" name="title" type="text" value='<?= htmlspecialchars($poll["title"]); ?>' required
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
                    placeholder="Enter the description..."
                    require><?= htmlspecialchars($poll["description"]) ?? "" ?></textarea>
                <div class="text-red-500 text-sm"><?= $errors["description"] ?? "" ?></div>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="start_time" class="block text-sm font-medium leading-6 text-gray-900">Start time</label>
                </div>
                <div class="mt-2">
                    <input id="start_time" name="start_time" type="datetime-local"
                        value='<?= htmlspecialchars($poll["start_time"]); ?>' require
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="text-red-500 text-sm"><?= $errors["start_time"] ?? "" ?></div>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="end_time" class="block text-sm font-medium leading-6 text-gray-900">End time</label>
                </div>
                <div class="mt-2">
                    <input id="end_time" name="end_time" type="datetime-local"
                        value='<?= htmlspecialchars($poll["end_time"]); ?>' require
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="text-red-500 text-sm"><?= $errors["end_time"] ?? "" ?></div>
            </div>
            <!-- options -->
            <div class="flex justify-center flex-col">
                <div class="flex justify-between items-center">
                    <h1 class="text-lg">Options</h1>
                    <button type="button" onclick="addOption()" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2">Add Option</button>
                </div>
                <div class="text-red-500 text-sm"><?= $errors["options"] ?? "" ?></div>
                <div id="options">
                    <?php foreach ($options as $option) : ?>
                        <div class="mt-2 flex justify-between items-center" id="option_<?=$option["id"]?>" onchange="editOption(<?=$option['id']?>)">
                            <input name="options[<?= $option["id"] ?>]" type="text" value="<?= htmlspecialchars($option["option_text"]) ?>"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <svg class="w-6 h-6 text-red-800 cursor-pointer" onclick="deleteOption(<?= $option["id"] ?>)" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    <?php endforeach ?>
                </div>
                <div id="optionsChanges">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>
    </div>
    </div>
</main>

<?php
$numOfOptions = end($options)['id'] + 1;
?>

<script>

    function appendToOptionsChanges(id,action){
        let optionsChanges = document.getElementById("optionsChanges");
        let input = document.createElement("input");
        input.type = "hidden"
        input.name = `${action}[${id}]`
        input.id = `${action}[${id}]`
        input.value = id

        optionsChanges.appendChild(input);
    }
    
    // add option
    let numOfOptions = <?= $numOfOptions; ?>;
    function addOption() {
        let option = `<div class="mt-2 flex justify-between items-center" id="option_${numOfOptions}" onchange="editOption(${numOfOptions})">
                        <input name="options[${numOfOptions}]" type="text" 
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                        <svg class="w-6 h-6 text-red-800 cursor-pointer" onclick="deleteOption(${numOfOptions})" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                        </svg>
                    </div>`
        let temp = document.createElement('div');
        temp.innerHTML = option
        document.getElementById("options").appendChild(temp)

        appendToOptionsChanges(numOfOptions,"added")

        numOfOptions++
    }

    //delete items
    function deleteOption(id) {
        document.getElementById("option_" + id).remove();
        appendToOptionsChanges(id,"deleted")
        removeAddedOrEditedOption(id)
    }

    function removeAddedOrEditedOption(id) {
        let added = document.getElementById(`added[${id}]`);
        if (added != null) {
            added.remove()
        }

        let edited = document.getElementById(`edited[${id}]`);
        if (edited != null) {
            edited.remove()
        }

        if(added || edited){
            document.getElementById(`deleted[${id}]`).remove()
        }
    }

    //edit
    function editOption(id){
        let added = document.getElementById(`added[${id}]`);
        if (added == null) {
            console.log(id);
            appendToOptionsChanges(id,"edited");
        }
    }
</script>
<?php require "../views/partials/footer.view.php"; ?>