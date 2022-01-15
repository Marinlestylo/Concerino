<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="mt-24 text-5xl text-center text-blue-400">Login</h1>
<div class="w-full max-w-sm mx-auto mt-16">
    <div class="px-20 py-8 bg-blue-700 rounded-lg card md:pr-16 md:pl-2">
        <form class="add-meal" method="POST" action="/login">
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="email">
                        Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-blue-100 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="email" id="email" name="email" required autocomplete="off" placeholder="exemple@gmail.com">
                </div>
            </div>
            <div class="mb-6 md:flex md:items-center">
                <div class="md:w-1/3">
                    <label class="block pr-4 mb-1 font-bold text-center text-indigo-100 md:text-right md:mb-0" for="password">
                        Mot de passe
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="w-full px-4 py-2 leading-tight text-gray-900 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-blue-800" type="password" id="password" name="password" required autocomplete="off" placeholder="••••••••••">
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button type="submit" class="justify-center px-4 py-2 ml-8 font-bold text-indigo-100 bg-blue-900 rounded shadow hover:shadow-xl focus:shadow-outline focus:outline-none">
                        Se connecter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

<?php require('app/views/partials/footer.php'); ?>