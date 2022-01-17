<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Créer une salle de concert</h1>
<div class="w-full max-w-lg mx-auto mt-16 mb-16">
    <div class="px-20 py-8 bg-blue-700 rounded-lg card md:pr-16 md:pl-2">
        <form class="add-meal" method="POST" action="/createRoom" autocomplete="off">
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="name">
                        Nom de la salle
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="name" name="name" required autocomplete="off" placeholder="Le diabolo">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="capacity">
                        Capacité
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="number" id="capacity" name="capacity" required autocomplete="off" placeholder="45000">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="streetName">
                        Nom de la rue
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="streetName" name="streetName" required autocomplete="off" placeholder="Route de Genève">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="streetNumber">
                        Numéro de la rue
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="streetNumber" name="streetNumber" required autocomplete="off" placeholder="12">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="npa">
                        NPA
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="number" id="npa" name="npa" required autocomplete="off" placeholder="1004">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="city">
                        Localité
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="city" name="city" required autocomplete="off" placeholder="Lausanne">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                    <div class="md:w-1/3">
                        <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="type">
                            Type de la salle
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="type" id="type" class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="number" id="time" name="time" required>
                            <?php foreach ($typeLieu as $type) : ?>
                                <option value="<?= $type->unnest ?>"><?= $type->unnest ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <div class="flex items-center justify-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button type="submit" class="justify-center px-4 py-2 ml-4 font-bold text-indigo-100 bg-blue-900 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                        Créer une salle de concert
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require('app/views/partials/footer.php'); ?>