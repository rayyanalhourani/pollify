<?php
require "../views/partials/header.view.php";
require "../views/partials/nav.view.php";
?>

<main>
    <div class="mx-auto p-6 my-4 w-[1100px] bg-white shadow-md">
        <div class="px-4  px-0">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Poll Information</h3>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-md font-medium leading-6 text-gray-900">Title</dt>
                    <dd class="mt-1 text-md leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['title'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-md font-medium leading-6 text-gray-900">Description</dt>
                    <dd class="mt-1 text-md leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['description'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-md font-medium leading-6 text-gray-900">Start time</dt>
                    <dd class="mt-1 text-md leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['start_time'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-md font-medium leading-6 text-gray-900">End time</dt>
                    <dd class="mt-1 text-md leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['end_time'] ?></dd>
                </div>
                <div class="px-4 py-4">
                    <dt class="text-md font-medium leading-6 text-gray-900">Options</dt>
                    <form action="/voting/vote" method="POST" class="flex flex-col items-center justify-center mt-10 gap-3">
                        <?php foreach ($options as $option) : ?>
                            <div class="flex items-center ps-4 border border-gray-200 rounded min-w-96">
                                <input type="hidden" name="poll_id" value="<?= $option["poll_id"] ?>">
                                <input id="option_<?= $option['id'] ?>" type="radio" value="<?= $option['id'] ?>" name="option" class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-600 focus:ring-blue-500 focus:ring-2 "
                                    <?= $vottedOption == $option['id'] ? "checked" : "" ?>>
                                <label for="option_<?= $option['id'] ?>" class="w-full py-4 ms-2 text-md font-medium text-gray-900 dark:text-gray-300"><?= $option['option_text'] ?></label>
                                <p id="optionCount_<?= $option['id'] ?>" class="px-4 text-md"></p>
                            </div>
                        <?php endforeach; ?>
                        <div class="text-red-500 text-lg"><?= $error ?? "" ?></div>
                        <input type="submit" class="mt-3 text-white bg-green-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 me-2 mb-2 focus:outline-none">
                    </form>
                </div>
            </dl>
        </div>
    </div>
</main>


<script>
    const searchParams = new URLSearchParams(window.location.search);
    let id = searchParams.get('id');

    let echo_service;
    window.onload = function() {

        echo_service = new WebSocket('ws://127.0.0.1:8085');

        echo_service.onmessage = function(event) {
            if (isJson(event.data)) {
                let data = JSON.parse(event.data);
                console.log(data);
                
                data.forEach(option => {
                    let option_id = option["id"];
                    let count = option["count"] ?? 0;
                    document.getElementById("optionCount_" + option_id).innerHTML = count;
                });
            } else {
                console.log(event.data);
            }
            sendMessage()
        }

        echo_service.onopen = function() {
            console.log("Connected to WebSocket!");
        }
        echo_service.onclose = function() {
            console.log("Connection closed");
        }
        echo_service.onerror = function() {
            console.log("Error happens");
        }

        function sendMessage() {
            echo_service.send(id);
        }

        setInterval(sendMessage, 50)

        function isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    }
</script>



<?php require "../views/partials/footer.view.php"; ?>