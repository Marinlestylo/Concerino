<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

    <h1 class="mt-24 text-5xl text-center text-blue-400">Voici la page de <?= $data['artist'][0]->nomscène ?></h1>
    <div class="flex flex-col items-center mt-12">
        <div class="max-w-5xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom de scène
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Prénom
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Style(s) de musique de l'artiste
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Moyenne de l'artiste
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Groupe actuel
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                            <?= $data['artist'][0]->nomscène ?>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                            <?= $data['artist'][0]->prénom ?>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                            <?= $data['artist'][0]->nom ?>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                            <?php if (isset($data['artist'][0]->styles)) : ?>
                                <?= $data['artist'][0]->styles ?>
                            <?php else : ?>
                                Aucun
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                            <?php if (isset($data['moyenne'][0]->moyenne)) : ?>
                                <?= number_format($data['moyenne'][0]->moyenne, 2) ?> / 5
                            <?php else : ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                            <?php if (isset($data['artist'][0]->nomgroupe)) : ?>
                                <a href="/group?id=<?= $data['artist'][0]->id ?>"
                                   class="hover:text-black hover:underline ">
                                    <?= $data['artist'][0]->nomgroupe ?>
                                </a>
                            <?php else : ?>
                                Aucun
                            <?php endif; ?>
                        </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php if (isset($_SESSION['id'])) : ?>
    <div class="flex justify-center text-center">
        <form action="/noteArtist" method="POST">
            <input class="" value="<?= $_GET['id'] ?>" type="hidden" id="idArtist" name="idArtist" required>
            <input class="" value="<?= $_SESSION['id'] ?>" type="hidden" id="idUser" name="idUser" required>
            <label for="note" class="block pr-4 font-bold text-center text-indigo-500 md:text-right md:mb-0">Une note
                doit être un entier compris entre 0 et 5</label>
            <input class="px-4 py-2 leading-tight text-gray-900 border-2 border-gray-200 rounded appearance-none w-md focus:outline-none focus:bg-white focus:border-blue-800"
                   type="number" id="note" name="note" required>
            <button type="submit"
                    class="justify-center px-4 py-2 mt-2 ml-4 font-bold text-white bg-blue-500 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                Noter l'artiste
            </button>
        </form>
    </div>
    <div class="block pr-4 text-sm text-center text-indigo-500">Vous devez avoir assisté à un concert de cet artiste
        afin de pouvoir le noter.
    </div>
<?php endif; ?>

<?php if (count($data['groups']) == 0) : ?>
    <h1 class="mt-24 text-5xl text-center text-blue-400"><?= $data['artist'][0]->nomscène ?> n'a jamais fait partie d'un
        groupe</h1>
<?php else : ?>
    <h1 class="mt-24 text-5xl text-center text-blue-400">Liste des groupes dont <?= $data['artist'][0]->nomscène ?> a
        fait partie</h1>
    <div class="flex flex-col items-center mt-12">
        <div class="max-w-3xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 sorted-table" data-sortlist="[[0,0]]">
                        <thead class="bg-blue-600">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom du groupe
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Style(s) de musique
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Date de début
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Date de fin
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['groups'] as $group) : ?>
                        <tr class="hover:bg-gray-100">
                            <td scope="col" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <a href="/group?id=<?= $group->id ?>" class="hover:text-black hover:underline ">
                                    <?= $group->nomscène ?>
                                </a>
                            </td>
                            <td scope="col" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $group->styles ?>
                            </td>
                            <td scope="col" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?php
                                $array = explode(' ', $group->datedébut);
                                $date = explode('-', $array[0]);
                                echo($date[2] . '.' . $date[1] . '.' . $date[0]);
                                ?>
                            </td>
                            <td scope="col" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?php if (isset($group->datefin)) : ?>
                                    <?php
                                    $array = explode(' ', $group->datefin);
                                    $date = explode('-', $array[0]);
                                    echo($date[2] . '.' . $date[1] . '.' . $date[0]);
                                    ?>
                                <?php else : ?>
                                    ---
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (count($data['suggestions']) > 0) : ?>
    <h1 class="mt-24 text-5xl text-center text-blue-400">Artistes similaires</h1>
    <div class="flex flex-col items-center mt-12">
        <div class="max-w-3xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 sorted-table" data-sortlist="[[0,0]]">
                        <thead class="bg-blue-600">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom de l'artiste
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Style(s) de musique
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Groupe?
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['suggestions'] as $artist) : ?>
                        <tr class="hover:bg-gray-100">
                            <td scope="col" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <a href="/<?php echo ($artist->estgroupe ? "group" : "artist") . "?id=" . $artist->id ?>"
                                   class="hover:text-black hover:underline ">
                                    <?= $artist->nomscène ?>
                                </a>
                            </td>
                            <td scope="col" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $artist->styles ?>
                            </td>
                            <td scope="col" class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $artist->estgroupe ? 'oui' : 'non' ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php require('app/views/partials/footer.php'); ?>