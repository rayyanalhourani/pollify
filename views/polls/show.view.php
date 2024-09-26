<?php
require "../views/partials/header.view.php";
require "../views/partials/nav.view.php";
?>

<main>
    <div class="mx-auto p-6 my-4 w-[1100px] bg-white shadow-md">
        <div class="px-4  px-0">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Poll Information</h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Poll and votes details.</p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Title</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['title'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Description</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['description'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Owner</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['owner'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Start time</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['start_time'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">End time</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?= $poll['end_time'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">Number of option</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?= count($options) ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">Total votes</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?= $votes['count'] ?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Options</dt>
                    <dd class="mt-2 text-sm text-gray-900  col-span-2  mt-0">
                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                            <?php foreach ($options as $option) : ?>
                                <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <span class="truncate font-medium"><?= $option["option_text"] ?></span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <p id="optionCount_<?= $option['option_id'] ?>" class="font-medium text-indigo-600 hover:text-indigo-500"></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</main>

<script>
    const searchParams = new URLSearchParams(window.location.search);
    let poll_id = searchParams.get('id');

    let echo_service;
    window.onload = function() {
        echo_service = new WebSocket('ws://127.0.0.1:8085');

        echo_service.onmessage = function(event) {
            let data = event.data;

            if (!isJson(data)) {
                console.log(data);
                return;
            }

            let response = JSON.parse(data);


            if (response["status"] == "success") {
                let result = response.result;

                result.forEach(option => {
                    let option_id = option["id"];
                    let count = option["count"] ?? 0;
                    document.getElementById("optionCount_" + option_id).innerHTML = count;
                });
            }
        }

        echo_service.onopen = function() {
            console.log("Connected to WebSocket!");
            sendMessage({
                poll_id: poll_id,
                action: "get"
            })
        }
        echo_service.onclose = function() {
            console.log("Connection closed");
        }
        echo_service.onerror = function() {
            console.log("Error happens");
        }

        function sendMessage($msg) {
            echo_service.send(JSON.stringify($msg));
        }

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