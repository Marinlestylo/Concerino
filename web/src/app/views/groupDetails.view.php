<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Voici la liste des artistes</h1>
<div class="flex justify-center mb-12">
    <div class="flex flex-col items-center mr-48">
        <div class="mt-10 text-2xl text-center text-blue-400 mb-4">Artistes</div>
        <div class="max-w-2xl -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Nom de scène
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Prénom
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-blue-100 uppercase">
                                    Nom
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php require('app/views/partials/footer.php'); ?>