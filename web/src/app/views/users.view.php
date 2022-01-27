<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

    <h1 class="mt-24 text-5xl text-center text-blue-400">Voici la liste des utilisateurs</h1>

    <div class="flex flex-col items-center mt-12">
        <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 sorted-table" data-sortlist="[[0,0]]">
                        <thead class="bg-blue-600">
                        <tr>
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
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Rôle
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user) : ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 text-center text-gray-500 hover:text-black hover:underline whitespace-nowrap">
                                    <a href="/user?id=<?= $user->id ?>"><?= $user->prénom; ?></a>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 hover:text-black hover:underline whitespace-nowrap">
                                    <a href="/user?id=<?= $user->id ?>"><?= $user->nom; ?></a>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 hover:text-black hover:underline whitespace-nowrap">
                                    <a href="/user?id=<?= $user->id ?>"><?= $user->login; ?></a>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
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