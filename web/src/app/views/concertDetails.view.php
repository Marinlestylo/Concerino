<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Détails du concert
    <?= $concert[0]->nom ?>
</h1>

<div class="flex flex-col items-center mt-12">
    <div class="max-w-6xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom du concert
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Début du concert
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Durée
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Lieu
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nombre de personnes ayant assisté au concert
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Moyenne des notes du concert
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $concert[0]->nom; ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?php
                                $array = explode(' ', $concert[0]->début);
                                $date = explode('-', $array[0]);
                                echo ($date[2] . '.' . $date[1] . '.' . $date[0]);
                                $hour = explode(':', $array[1]);
                                echo (" à " . $hour[0] . "h" . $hour[1]);
                                ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $concert[0]->durée . ' minutes'; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 hover:underline whitespace-nowrap">
                                <a href="/room?nom=<?= $concert[0]->nomlieu ?>"><?= $concert[0]->nomlieu; ?></a>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 hover:text-black whitespace-nowrap">
                                TODO
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                TODO
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<h1 class="mt-24 text-5xl text-center text-blue-400">Le créateur du concert est <?= $concert[0]->prénom . ' ' . $concert[0]->nomUser ?></h1>
<h1 class="mt-6 text-xl text-center text-blue-800 hover:underline"><a href="/user?id=<?= $concert[0]->idcréateur ?>">Cliquez ici pour voir son profil</a></h1>

<?php require('app/views/partials/footer.php'); ?>