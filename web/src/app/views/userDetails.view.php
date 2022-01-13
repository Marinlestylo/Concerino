<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Détails de l'utilisateur
    <?= $user[0]->prénom . ' ' . $user[0]->nom; ?>
</h1>


<div class="flex flex-col items-center mt-12">
    <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-blue-100 uppercase">
                                Prénom
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-blue-100 uppercase">
                                Nom
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-blue-100 uppercase">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-blue-100 uppercase">
                                Rôle
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                <?= $user[0]->prénom; ?>
                            </td>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                <?= $user[0]->nom; ?>
                            </td>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                <?= $user[0]->login; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                <?php if ($user[0]->estmodérateur) : ?>
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
    <?= $user[0]->prénom . ' ' . $user[0]->nom; ?> a participé
</h1>

<h1 class="mt-24 text-5xl text-center text-blue-400">Voici les concerts créé par
    <?= $user[0]->prénom . ' ' . $user[0]->nom; ?>
</h1>

<h1 class="mt-24 text-5xl text-center text-blue-400">Voici les votes émis par
    <?= $user[0]->prénom . ' ' . $user[0]->nom; ?>
</h1>


<?php require('app/views/partials/footer.php'); ?>