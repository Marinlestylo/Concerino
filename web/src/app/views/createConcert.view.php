<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>


    <h1 class="mt-24 text-5xl text-center text-blue-400">Créer un concert</h1>
    <div class="mt-6 text-xl text-center text-blue-400">N'oubliez pas de <a href="/createRoom"
                                                                            class="hover:underline hover:text-blue-800">créer
            la salle du concert</a> avant de créer ledit concert<br>

    </div>
<?php if (count($data['lieux']) == 0 || count($data['artists']) == 0) : ?>
    <div class="mt-6 text-xl text-center text-red-400"><?= "Vous devez d'abord créer une salle de concert !" ?></div>
<?php else : ?>
    <div class="w-full max-w-lg mx-auto mt-16">
        <div class="px-20 py-8 bg-blue-700 rounded-lg card md:pr-16 md:pl-2">
            <form class="add-meal" method="POST" action="/createConcert" autocomplete="off">
                <div class="mb-6 md:flex md:items-center">
                    <div class="md:w-1/3">
                        <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0"
                               for="name">
                            Nom du concert
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800"
                               type="text" id="name" name="name" required autocomplete="off" placeholder="Le diabolo">
                    </div>
                </div>
                <div class="mb-6 md:flex md:items-center">
                    <div class="md:w-1/3">
                        <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0"
                               for="date">
                            Date du concert
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800"
                               type="text" id="date" name="date" required autocomplete="off" placeholder="yyyy-mm-dd">
                    </div>
                </div>
                <div class="mb-6 md:flex md:items-center">
                    <div class="md:w-1/3">
                        <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0"
                               for="hour">
                            Heure de début
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800"
                               type="text" id="hour" name="hour" required autocomplete="off" placeholder="17:30">
                    </div>
                </div>
                <div class="mb-6 md:flex md:items-center">
                    <div class="md:w-1/3">
                        <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0"
                               for="duration">
                            Durée [min]
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800"
                               type="number" id="duration" name="duration" required autocomplete="off"
                               placeholder="120">
                    </div>
                </div>
                <div class="mb-6 md:flex md:items-center">
                    <div class="md:w-1/3">
                        <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0"
                               for="place">
                            Lieu du concert
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="place" id="place"
                                class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800"
                                type="number" id="time" name="time" required>
                            <?php foreach ($data['lieux'] as $lieu) : ?>
                                <option value="<?= $lieu->id ?>"><?= $lieu->nom ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-6 md:flex md:items-center">
                    <div class="md:w-1/3">
                        <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0">
                            Artistes
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="min-w-full divide-y divide-gray-200 sorted-table">
                            <ol id="artists" class="list-decimal">
                                <li class="artist-row">
                                    <span class="tablesorter-header"></span>
                                    <select name="artists[]" class="px-4 py-2 leading-tight text-gray-900 bg-gray-200
                                    border-2
                                                border-gray-200 rounded appearance-none focus:outline-none
                                                focus:bg-white focus:border-blue-800 synced-list" required>
                                        <?php foreach ($data['artists'] as $artiste) : ?>
                                            <option value="<?= $artiste->nomscène ?>"><?= $artiste->nomscène ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4
                         rounded inline-flex items-center" data-role="add">
                                        <span>+</span>
                                    </button>
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4
                         rounded inline-flex items-center" data-role="remove">
                                        <span>-</span>
                                    </button>
                                </li>
                            </ol>

                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button type="submit"
                                class="justify-center px-4 py-2 ml-4 font-bold text-indigo-100 bg-blue-900 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                            Créer un concert
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function syncLists() {
            let vals = [];
            let optionsLength;

            $('.synced-list').each(function () {
                const val = $(this).val();
                if (val !== "") {
                    vals.push(val);
                }
                let options = $(this).find('option');
                options.show();
                optionsLength = options.length;
                for (let i = 0; i < vals.length; i++) {
                    $('option[value="' + vals[i] + '"]').hide();
                }
            });
            $('button[data-role="add"]').prop('disabled', vals.length === optionsLength);
        }

        $(function () {
            const artists = $('#artists');

            $(document).on('click', 'button[data-role="remove"]', function () {
                $(this).closest('.artist-row').remove();
                syncLists();
            });
            $(document).on('click', 'button[data-role="add"]', function () {
                const row = $(this).closest('.artist-row').clone();
                artists.append(row);
                row.find('option:visible').first().prop('selected', true);
                syncLists();
            });
            $(document).on('change', '.synced-list', function () {
                syncLists();
            });

            artists.sortable();
            syncLists();
        });
    </script>
    <style>
        .artist-row [data-role="add"] {
            display: none;
        }

        .artist-row:last-child [data-role="add"] {
            display: inline-block;
        }

        .artist-row:last-child [data-role="remove"] {
            display: none;
        }
    </style>
<?php endif; ?>
<?php require('app/views/partials/footer.php'); ?>