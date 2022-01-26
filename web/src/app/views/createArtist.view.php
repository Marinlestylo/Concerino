<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Créer une salle de concert</h1>
<div class="w-full max-w-lg mx-auto mt-16">
    <div class="px-20 py-8 bg-blue-700 rounded-lg card md:pr-16 md:pl-2">
        <form method="POST" action="/createArtist" autocomplete="off">
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="Sname">
                        Nom de scène
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="Sname" name="Sname" required autocomplete="off" placeholder="Eminem">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="fName">
                        Prénom
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="fName" name="fName" required autocomplete="off" placeholder="Marshall Bruce">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="lName">
                        Nom
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="lName" name="lName" required autocomplete="off" placeholder="Mathers ">
                </div>
            </div>
            <div class="justify-center mb-6 md:flex md:items-center">
                <fieldset>
                    <legend class="pr-4 mb-1 font-bold text-center text-indigo-100 w-fullblock md:text-right md:mb-0">Quels sont les styles de l'artiste ?</legend>
                    <?php foreach ($data['styles'] as $style) : ?>
                        <div class="block pr-4 mb-1 font-bold text-indigo-100">
                            <input type="checkbox" id="<?= $style->nom ?>" name="styles[]" value="<?= $style->nom ?>">
                            <label for="<?= $style->nom ?>"><?= $style->nom ?></label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="group">
                        Groupe de l'artiste
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="group" id="group" class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="number" id="time" name="time" required>
                        <option value="None">Aucun groupe </option>
                        <?php foreach ($data['groups'] as $group) : ?>
                            <option value="<?= $group->nomscène ?>"><?= $group->nomscène ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="date">
                        Date d'entrée dans le groupe
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="date" name="date" autocomplete="off" placeholder="aaaa-mm-jj ">
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button type="submit" class="justify-center px-4 py-2 ml-4 font-bold text-indigo-100 bg-blue-900 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                        Créer un artiste
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require('app/views/partials/footer.php'); ?>