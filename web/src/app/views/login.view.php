<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="text-blue-400 text-center mt-24 text-5xl">Login</h1>
<div class="w-full max-w-sm mx-auto mt-16">
        <div class="card bg-blue-700 rounded-lg py-8 px-20 md:pr-16 md:pl-2">
            <form class="add-meal" method="POST" action="/login">
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-center text-indigo-100 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                            Email
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-gray-200 appearance-none border-2 border-blue-100 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-800"
                            type="text" id="email" name="email" required autocomplete="off" placeholder="exemple@gmail.com">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-center text-indigo-100 font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                            Mot de passe
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-900 leading-tight focus:outline-none focus:bg-white focus:border-blue-800"
                            type="password" id="password" name="password" required autocomplete="off" placeholder="••••••••••">
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button type="submit" class="shadow ml-8 justify-center bg-blue-900 hover:shadow-xl focus:shadow-outline focus:outline-none text-indigo-100 font-bold py-2 px-4 rounded">
                            Se connecter
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    
<?php require('app/views/partials/footer.php'); ?>