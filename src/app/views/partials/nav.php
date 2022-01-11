<header class="bg-blue-600">
        <nav class="container py-4 mx-auto sm:flex flex-wrap items-center w-full">
            <a href="/" class="flex justify-center items-center">
                <span class="font-semibold text-3xl tracking-tight text-blue-100">Concer'ino</span>
                <img src="https://i.pinimg.com/originals/86/32/ae/8632aeda3e648ffe76c02bd7e9457f79.jpg" alt="Le logo" width=100>
            </a>
            <div class="flex flex-grow justify-center items-center">
                <div class="text-sm sm:ml-6">
                    <a href="/users" class="hover:text-indigo-200 text-indigo-100 text-xl">
                        Utilisateurs
                    </a>
                    <?php if(isset($_SESSION['login'])) : ?>
                        <a class="font-semibold text-xl tracking-tight text-blue-100 ml-24">
                            Connecté en tant que : <?= $_SESSION['prénom']?>
                        </a>
                        <a href="/logout" class="mr-6 bg-white hover:bg-blue-700 text-blue-500 font-bold py-2 px-4 border border-blue-700 rounded ml-10">
                            Se déconnecter
                        </a>
                        <?php else : ?>
                        <a href="/login" class="mr-6 bg-white hover:bg-blue-700 text-blue-500 font-bold py-2 px-4 border border-blue-700 rounded ml-6">
                            Se connecter
                        </a>
                        <a href="/createAccount" class="mr-6 bg-white hover:bg-blue-700 text-blue-500 font-bold py-2 px-4 border border-blue-700 rounded">
                            Créer un compte
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>