<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Détails de l'utilisateur
    <?= $data['user'][0]->prénom . ' ' . $data['user'][0]->nom; ?>
</h1>


<div class="flex flex-col items-center mt-12">
    <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Prénom
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Nom
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Rôle
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $data['user'][0]->prénom; ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $data['user'][0]->nom; ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $data['user'][0]->login; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                <?php if ($data['user'][0]->estmodérateur) : ?>
                                    Modérateur
                                <?php else : ?>
                                    Utilisateur
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<h1 class="mt-24 text-5xl text-center text-blue-400">Voici les concerts auxquels
    <?= $data['user'][0]->prénom . ' ' . $data['user'][0]->nom; ?> a et va participé
</h1>

<?php if (count($data['seen']) < 1) : ?>
    <h1 class="mt-6 text-xl text-center text-blue-400"><?= $data['user'][0]->prénom . ' ' . $data['user'][0]->nom; ?>
        n'a pas encore pris part à un concert</h1>
<?php else : ?>
    <div class="flex flex-col items-center mt-12">
        <div class="max-w-5xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 sorted-table" data-sortlist="[[1,1]]">
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
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($data['seen'] as $concert) : ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 text-center text-gray-500 hover:underline hover:text-black whitespace-nowrap">
                                        <a href="/concert?id=<?= $concert->id ?>"><?= $concert->nom; ?></a>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap" data-text="<?= $concert->début ?>">
                                        <?php
                                        $array = explode(' ', $concert->début);
                                        $date = explode('-', $array[0]);
                                        echo ($date[2] . '.' . $date[1] . '.' . $date[0]);
                                        $hour = explode(':', $array[1]);
                                        echo (" à " . $hour[0] . "h" . $hour[1]);
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        <?= $concert->durée . ' minutes'; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-500 hover:underline hover:text-black whitespace-nowrap">
                                        <a href="/room?nom=<?= $concert->nomlieu ?>"><?= $concert->nomlieu; ?></a>
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

<h1 class="mt-24 text-5xl text-center text-blue-400">Voici les concerts créé par
    <?= $data['user'][0]->prénom . ' ' . $data['user'][0]->nom; ?>
</h1>
<?php if (count($data['concerts']) < 1) : ?>
    <h1 class="mt-6 text-xl text-center text-blue-400"><?= $data['user'][0]->prénom . ' ' . $data['user'][0]->nom; ?>
        n'a pas encore créé de concert</h1>
<?php else : ?>
    <div class="flex flex-col items-center mt-12">
        <div class="max-w-5xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 sorted-table" data-sortlist="[[1,1]]">
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
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($data['concerts'] as $concert) : ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 text-center text-gray-500 hover:underline hover:text-black whitespace-nowrap">
                                        <a href="/concert?id=<?= $concert->id ?>"><?= $concert->nom; ?></a>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap" data-text="<?= $concert->début ?>">
                                        <?php
                                        $array = explode(' ', $concert->début);
                                        $date = explode('-', $array[0]);
                                        echo ($date[2] . '.' . $date[1] . '.' . $date[0]);
                                        $hour = explode(':', $array[1]);
                                        echo (" à " . $hour[0] . "h" . $hour[1]);
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        <?= $concert->durée . ' minutes'; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-500 hover:underline hover:text-black whitespace-nowrap">
                                        <a href="/room?nom=<?= $concert->nomlieu ?>"><?= $concert->nomlieu; ?></a>
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
<h1 class="mt-24 text-5xl text-center text-blue-400">Voici les votes émis par
    <?= $data['user'][0]->prénom . ' ' . $data['user'][0]->nom; ?>
</h1>

<div class="flex justify-center">
    <div class="flex flex-col items-center mt-12 mr-16">
        <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Salles
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Notes
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (count($data['votes']['lieux']) == 0) : ?>
                                <tr>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        ---
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        ---
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($data['votes']['lieux'] as $vote) : ?>
                                    <tr>
                                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap hover:text-black hover:underline">
                                            <a href="/room?nom=<?= $vote->nom ?>"><?= $vote->nom ?></a>
                                        </td>
                                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                            <?= $vote->note ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center mt-12 mr-16">
        <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Concerts
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Notes
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (count($data['votes']['concerts']) == 0) : ?>
                                <tr>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        ---
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        ---
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($data['votes']['concerts'] as $vote) : ?>
                                    <tr>
                                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap hover:text-black hover:underline">
                                            <a href="concert?id=<?= $vote->idconcert ?>"><?= $vote->nom ?></a>
                                        </td>
                                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                            <?= $vote->note ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center mt-12">
        <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Artistes
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Notes
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (count($data['votes']['artists']) == 0) : ?>
                                <tr>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        ---
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                        ---
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($data['votes']['artists'] as $vote) : ?>
                                    <tr>
                                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap hover:text-black hover:underline">
                                            <a href="artist?id=<?= $vote->idartiste ?>"><?= $vote->nomscène ?></a>
                                        </td>
                                        <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                            <?= $vote->note ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('app/views/partials/footer.php'); ?>