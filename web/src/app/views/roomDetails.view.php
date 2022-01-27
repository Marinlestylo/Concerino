<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Détails du lieu de concert de
    <?= $room[0]->nom ?>
</h1>


<div class="flex flex-col items-center mt-12">
    <div class="max-w-5xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
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
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                Moyenne des notes
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $room[0]->nom; ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $room[0]->capacité ?> personnes
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 whitespace-nowrap">
                                <?= $room[0]->nomrue . ' ' . $room[0]->norue ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                <?= $room[0]->npa . ' ' . $room[0]->localité ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                <?= $room[0]->typelieu ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                <?php 
                                if($room[0]->avg){
                                    echo(number_format($room[0]->avg, 2) . ' / 5');
                                }else{
                                    echo('-');
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

<?php if (isset($_SESSION['id'])) : ?>
    <div class="flex justify-center text-center">
        <form action="/noteRoom" method="POST">
            <input class="" value="<?= $room[0]->nom ?>" type="hidden" id="nomSAlle" name="nomSAlle" required>
            <input class="" value="<?= $_SESSION['id'] ?>" type="hidden" id="idUser" name="idUser" required>
            <label for="note" class="block pr-4 font-bold text-center text-indigo-500 md:text-right md:mb-0">Une notre doit être un entier compris entre 0 et 5</label>
            <input class="w-md px-4 py-2 leading-tight text-gray-900 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" value="<?= $room[0]->nom ?>" type="number" id="note" name="note" required>
            <button type="submit" class="justify-center px-4 py-2 mt-2 ml-4 font-bold text-white bg-blue-500 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                Noter le concert
            </button>
        </form>
    </div>
    <div class="block pr-4 text-sm text-center text-indigo-500">Vous devez avoir assisté à un concert dans cette salle pour pouvoir la noter</div>
<?php endif; ?>

<?php require('app/views/partials/footer.php'); ?>