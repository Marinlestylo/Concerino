<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>
   
<h1 class="text-blue-400 text-center mt-24 text-5xl">Voici la liste des villes</h1>
    <h2 class="text-center text-lg text-blue-400">
        <ul>
            <?php foreach ($users as $user) : ?>
                <li><?= $user->nom; ?></li>
            <?php endforeach; ?>
        </ul>
    </h2>
    <form action="/users" method="POST">
        <input name="name"></input>
        <button type="submit">Submit</button>
    </form>
<?php require('app/views/partials/footer.php'); ?>