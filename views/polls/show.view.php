<?php
require "../views/partials/header.view.php";
require "../views/partials/nav.view.php";
?>

<main>
    <div class="mx-auto p-6 my-4 w-[1100px] bg-white shadow-md" >
        <div class="px-4  px-0">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Poll Information</h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Poll and votes details.</p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Title</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?=$poll['title']?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Description</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?=$poll['description']?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Owner</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?=$poll['owner']?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Start time</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?=$poll['start_time']?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">End time</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?=$poll['end_time']?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">Number of option</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?=count($options)?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">Total votes</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700  col-span-2  mt-0"><?=$votes['count']?></dd>
                </div>
                <div class="px-4 py-4 grid grid-cols-3 gap-4 px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Options</dt>
                    <dd class="mt-2 text-sm text-gray-900  col-span-2  mt-0">
                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                            <?php foreach($options as $option) : ?>
                            <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                <div class="flex w-0 flex-1 items-center">
                                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                        <span class="truncate font-medium"><?=$option["option_text"]?></span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"><?=$option["vote_count"]?></a>
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

<?php require "../views/partials/footer.view.php"; ?>