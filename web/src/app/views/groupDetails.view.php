<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Voici la page du groupe <?= $data['info'][0]->nomscène ?></h1>
<h1 class="mt-6 text-2xl text-center text-blue-400">Ses styles de musique sont :
    <?php
    if (isset($data['info'][0]->styles)) {
        echo ($data['info'][0]->styles);
    } else {
        echo ('aucun');
    }
    ?>
</h1>
<?php if (isset($_SESSION['id'])) : ?>
    <div class="flex justify-center mt-10 text-center">
        <form action="/noteArtist" method="POST">
            <input class="" value="<?= $_GET['id'] ?>" type="hidden" id="idArtist" name="idArtist" required>
            <input class="" value="<?= $_SESSION['id'] ?>" type="hidden" id="idUser" name="idUser" required>
            <label for="note" class="block pr-4 font-bold text-center text-indigo-500 md:text-right md:mb-0">Une note doit être un entier compris entre 0 et 5</label>
            <input class="px-4 py-2 leading-tight text-gray-900 border-2 border-gray-200 rounded appearance-none w-md focus:outline-none focus:bg-white focus:border-blue-800" type="number" id="note" name="note" required>
            <button type="submit" class="justify-center px-4 py-2 mt-2 ml-4 font-bold text-white bg-blue-500 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                Noter le groupe
            </button>
        </form>
    </div>
    <div class="block pr-4 text-sm text-center text-indigo-500">Vous devez avoir assisté à un concert de cet artiste afin de pouvoir le noter.</div>
<?php endif; ?>
<h1 class="mt-24 text-5xl text-center text-blue-400">Voici la liste de tous ses membres</h1>


<div class="flex flex-col items-center mt-12">
    <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 sorted-table" data-sortlist="[[0,0]]">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom de scène
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Date d'entrée
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Date de séparation
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['members'] as $member) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 text-center text-gray-500 hover:text-black hover:underline whitespace-nowrap">
                                    <a href="/artist?id=<?= $member->idartistesolo ?>"><?= $member->nomscène; ?></a>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?php
                                    $array = explode(' ', $member->datedébut);
                                    $date = explode('-', $array[0]);
                                    echo ($date[2] . '.' . $date[1] . '.' . $date[0]);
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?php
                                    if (isset($member->datefin)) {
                                        $array = explode(' ', $member->datedébut);
                                        $date = explode('-', $array[0]);
                                        echo ($date[2] . '.' . $date[1] . '.' . $date[0]);
                                    } else {
                                        echo ('---');
                                    }
                                    ?>
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