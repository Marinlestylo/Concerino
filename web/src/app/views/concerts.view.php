<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

    <h1 class="mt-24 text-5xl text-center text-blue-400">Voici la liste de tous les concerts</h1>


<?php if (count($concerts) == 0) : ?>
    <h1 class="mt-6 text-xl text-center text-blue-400">Il n'y a pas encore de concert</h1>
<?php else : ?>
    <div class="flex flex-col items-center mt-12">
        <div class="max-w-5xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 sorted-table" data-sortlist="[[1,0]]">
                        <thead class="bg-blue-600">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase hover:cursor-pointer">
                                Nom du concert
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase hover:cursor-pointer">
                                Début du concert
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase hover:cursor-pointer">
                                Durée
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase hover:cursor-pointer">
                                Lieu
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase hover:cursor-pointer">
                                Nombre de participants
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase hover:cursor-pointer">
                                Info du créateur
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($concerts as $concert) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 text-center text-gray-500 hover:underline hover:text-black whitespace-nowrap">
                                    <a href="/concert?id=<?= $concert->id ?>"><?= $concert->nom; ?></a>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap"
                                    data-text="<?= $concert->début ?>">
                                    <?php
                                    $array = explode(' ', $concert->début);
                                    $date = explode('-', $array[0]);
                                    echo($date[2] . '.' . $date[1] . '.' . $date[0]);
                                    $hour = explode(':', $array[1]);
                                    echo(" à " . $hour[0] . "h" . $hour[1]);
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?= $concert->durée . ' minutes'; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 hover:underline hover:text-black whitespace-nowrap">
                                    <a href="/room?nom=<?= $concert->nomlieu ?>"><?= $concert->nomlieu; ?></a>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?= $concert->nbparticipant . '/' . $concert->nbmaxparticipant; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 hover:underline hover:text-black whitespace-nowrap">
                                    <a href="/user?id=<?= $concert->idcréateur ?>"><?= $concert->prénom . " " . $concert->nomUser; ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <a href="/createConcert"><h1 class="mt-10 text-xl text-center text-blue-400 hover:underline hover:text-blue-800">
            Cliquez ici pour créer un concert</h1></a>

<?php require('app/views/partials/footer.php'); ?>