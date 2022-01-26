<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Détails du concert
    <?= $data['concert'][0]->nom ?>
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
                                Nombre de participant au concert
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Moyenne des notes du concert
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $data['concert'][0]->nom; ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?php
                                $array = explode(' ', $data['concert'][0]->début);
                                $date = explode('-', $array[0]);
                                echo ($date[2] . '.' . $date[1] . '.' . $date[0]);
                                $hour = explode(':', $array[1]);
                                echo (" à " . $hour[0] . "h" . $hour[1]);
                                ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $data['concert'][0]->durée . ' minutes'; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-700 hover:underline whitespace-nowrap">
                                <a href="/room?nom=<?= $data['concert'][0]->nomlieu ?>"><?= $data['concert'][0]->nomlieu; ?></a>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 hover:text-black whitespace-nowrap">
                                <?= $data['concert'][0]->nbparticipants . '/' . $data['concert'][0]->nbmaxparticipants ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                <?php if (is_null($data['concert'][0]->moyennenotes)) {
                                    echo ('Aucune note');
                                } else {
                                    echo ($data['concert'][0]->moyennenotes . '/5');
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['id']) && ($_SESSION['id'] == $data['concert'][0]->idcréateur || $_SESSION['isAdmin'] == true)) : ?>
    <div class="flex justify-center text-center">
        <form action="/deleteConcert" method="POST">
            <input class="" value="<?= $data['concert'][0]->id ?>" type="hidden" id="idConcert" name="idConcert" required>
            <button type="submit" class="justify-center px-4 py-2 mt-6 ml-4 font-bold text-white bg-red-500 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                Supprimer le concert
            </button>
        </form>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['id']) && $data['signUp']) : ?>
    <div class="flex justify-center text-center">
        <form action="/signup" method="POST">
            <input class="" value="<?= $_SESSION['id'] ?>" type="hidden" id="idUser" name="idUser" required>
            <input class="" value="<?= $data['concert'][0]->id ?>" type="hidden" id="idConcert" name="idConcert" required>
            <button type="submit" class="justify-center px-4 py-2 mt-6 ml-4 font-bold text-indigo-100 bg-blue-900 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                S'inscrire au concert
            </button>
        </form>
    </div>
<?php elseif (!$data['signUp'] && isset($_SESSION['id'])) : ?>
    <div class="mt-6 text-xl text-center text-blue-800">Vous êtes déjà inscrit à ce concert</div>
<?php endif; ?>

<h1 class="mt-16 text-5xl text-center text-blue-400">Le créateur du concert est <?= $data['concert'][0]->prénom . ' ' . $data['concert'][0]->nomuser ?></h1>
<h1 class="mt-6 text-xl text-center text-blue-800 hover:underline"><a href="/user?id=<?= $data['concert'][0]->idcréateur ?>">Cliquez ici pour voir son profil</a></h1>

<h1 class="mt-24 text-5xl text-center text-blue-400">Groupes et artistes</h1>

<div class="flex flex-col items-center mt-12">
    <div class="max-w-6xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Noms
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Ordre de passage
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['artists'] as $artist) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?= $artist->nomscène ?>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                    <?= $artist->numéropassage ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<h1 class="mt-24 text-5xl text-center text-blue-400">Participants</h1>

<div class="flex flex-col items-center mt-12">
    <div class="max-w-6xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Noms
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($data['users'] as $user) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap hover:underline hover:text-black">
                                    <a href="/user?id=<?= $user->id ?>"><?= $user->prénom . ' ' . $user->nom ?></a>
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