<header class="flex justify-center bg-blue-600">
    <nav class="container flex-wrap items-center justify-center w-full py-4 mx-auto sm:flex">
        <a href="/" class="flex items-center justify-center pl-48" title="C'EST UN JEU DE MOT ! uWu (jo c'est un weeb)">
            <span class="text-3xl font-semibold tracking-tight text-blue-100">Concer'ino</span>
            <img src="../../../public/images/ino.jfif" alt="logo" width=100>
        </a>
        <div class="flex items-center justify-center flex-grow">
            <div class="text-sm sm:ml-6">
                <a href="/users" class="text-xl text-indigo-100 hover:text-indigo-200">
                    Utilisateurs
                </a>
                <a href="/concerts" class="ml-6 text-xl text-indigo-100 hover:text-indigo-200">
                    Concerts
                </a>
                <a href="/rooms" class="ml-6 text-xl text-indigo-100 hover:text-indigo-200">
                    Salles
                </a>
                <a href="/artists" class="ml-6 text-xl text-indigo-100 hover:text-indigo-200">
                    Artistes
                </a>
                <?php if (isset($_SESSION['login'])) : ?>
                    <a href="/user?id=<?= $_SESSION['id'] ?>"
                       class="ml-24 text-xl font-semibold tracking-tight text-blue-100">
                        Connecté en tant que : <?= $_SESSION['prénom'] ?>
                    </a>
                    <a href="/logout"
                       class="px-4 py-2 ml-10 mr-6 font-bold text-blue-500 bg-white border border-blue-700 rounded hover:bg-blue-700">
                        Se déconnecter
                    </a>
                <?php else : ?>
                    <a href="/login"
                       class="px-4 py-2 ml-6 mr-6 font-bold text-blue-500 bg-white border border-blue-700 rounded hover:bg-blue-700">
                        Se connecter
                    </a>
                    <a href="/createAccount"
                       class="px-4 py-2 mr-6 font-bold text-blue-500 bg-white border border-blue-700 rounded hover:bg-blue-700">
                        Créer un compte
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>