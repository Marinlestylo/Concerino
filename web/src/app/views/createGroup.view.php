<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Ajouter un groupe</h1>
<div class="w-full max-w-lg mx-auto mt-16">
    <div class="px-20 py-8 bg-blue-700 rounded-lg card md:pr-16 md:pl-2">
        <form method="POST" action="/createGroup" autocomplete="off">
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="Sname">
                        Nom du groupe
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="Sname" name="Sname" required autocomplete="off" placeholder="Linkin Park">
                </div>
            </div>
            <div class="px-4 mb-6 md:flex md:items-center">
                <fieldset>
                    <legend class="pr-4 mb-1 font-bold text-left text-indigo-100 w-fullblock md:text-right md:mb-0">Quels sont les styles du groupe ? </legend>
                    <?php foreach ($data['styles'] as $style) : ?>
                        <div class="block pr-4 mb-1 font-bold text-indigo-100">
                            <input type="checkbox" id="<?= $style->nom ?>" name="styles[]" value="<?= $style->nom ?>">
                            <label for="<?= $style->nom ?>"><?= $style->nom ?></label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>
            <div class="px-4 mb-6 md:flex md:items-center">
                <fieldset>
                    <legend class="pb-4 pr-4 mb-1 font-bold text-indigo-100 w-fullblock md:mb-0">Indiquez les membres du groupe et leur date d'entrée</legend>
                    <?php foreach ($data['artists'] as $artist) : ?>
                        <div class="block pr-4 mb-1 font-bold text-indigo-100">
                            <input type="checkbox" id="<?= $artist->nomscène ?>" name="members[]" value="<?= $artist->nomscène ?>">
                            <label for="<?= $artist->nomscène ?>"><?= $artist->nomscène ?></label>
                            <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="text" id="dates[]" name="dates[]" autocomplete="off" placeholder="aaaa-mm-jj">
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>
            <div class="flex items-center justify-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button type="submit" class="justify-center px-4 py-2 ml-4 font-bold text-indigo-100 bg-blue-900 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                        Créer un groupe
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require('app/views/partials/footer.php'); ?>