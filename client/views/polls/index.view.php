<?php
view("partials/header.view.php");
view("partials/nav.view.php");
?>

<main>
    <div class="mx-auto px-20 py-6">
        <div class="pb-4 bg-white p-3 flex justify-between	items-center">
            <div class="relative mt-1 ">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search" onkeyup="searchFilter()"
                    class="block ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 h-10"
                    placeholder="Search for items">
            </div>
            <div>
                <a href="/polls/create"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none cursor-pointer">Create</a>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            start_time
                        </th>
                        <th scope="col" class="px-6 py-3">
                            end_time
                        </th>
                        <th scope="col" class="px-6 py-3">
                            number of options
                        </th>
                        <th scope="col" class="px-6 py-3">
                            owner
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="pollsTable">
                    <?php foreach ($polls as $poll) : ?>
                        <tr class="bg-white border-b hover:bg-gray-50" id="poll_<?= $poll["id"] ?>">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?= htmlspecialchars($poll["title"]); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($poll["description"]); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($poll["start_time"]); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($poll["end_time"]); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($poll["option_count"]); ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($poll["owner"]); ?>
                            </td>
                            <td class="px-6 py-4 space-x-2">
                            <a href="/polls/show?id=<?= $poll["id"] ?>" class="text-md font-medium text-green-600 hover:underline">Show</a>
                                <a href="/polls/edit?id=<?= $poll["id"] ?>" class="font-medium text-blue-600 hover:underline">Edit</a>
                                <button onclick="deleteRow(<?= $poll['id'] ?>)" class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    async function deleteRow(id) {
        var formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('id', id);

        await fetch("/polls", {
            method: "POST",
            body: formData,
        }).then(data => {
            document.getElementById("poll_" + id).remove()
        }).catch(error => console.error('Error:', error));
    }

    function searchFilter() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("table-search");
        filter = input.value.toUpperCase();
        table = document.getElementById("pollsTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
<?php view("partials/footer.view.php"); ?>