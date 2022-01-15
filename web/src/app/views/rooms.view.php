<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Voici la liste des lieux de concert</h1>

<div class="flex flex-col items-center mt-12">
    <div class="max-w-6xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Capacité
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Adresse
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                 NPA et localité
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                type
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($rooms as $room) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap hover:underline hover:text-black">
                                <a href="/room?nom=<?= $room->nom ?>"><?= $room->nom; ?></a>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?= $room->capacité ?> personnes
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?= $room->nomrue . ' ' . $room->norue ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                    <?= $room->npa . ' ' . $room->localité ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                    <?= $room->typelieu ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require('app/views/partials/footer.php'); ?>