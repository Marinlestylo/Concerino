<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="text-blue-400 text-center mt-24 text-5xl">Voici la liste des utilisateurs</h1>

<div class="flex flex-col items-center">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 max-w-2xl">
        <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-lg sm:rounded-lg">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">
                                Prénom
                            </th>
                            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">
                                Nom
                            </th>
                            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">
                                Adresse mail
                            </th>
                            <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase">
                                Rôle
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Product -->
                        <?php foreach ($users as $user) : ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="py-4 px-6 text-sm text-gray-400 whitespace-nowrap">
                                    <?= $user->nom; ?>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-400 whitespace-nowrap">
                                    <?= $user->prénom; ?>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-400 whitespace-nowrap">
                                    <?= $user->login; ?>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-400 whitespace-nowrap">
                                    <?php if ($user->estmodérateur) : ?>
                                        Modérateur
                                    <?php else : ?>
                                        Utilisateur
                                    <?php endif; ?>
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