<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="text-blue-400 text-center mt-24 text-5xl">Voici la liste des concerts</h1>


<?php if (count($concerts) == 0) : ?>
    <h1 class="text-blue-400 text-center mt-24 text-xl">Il n'y a pas encore de concert</h1>
<?php else : ?>
    <h1 class="text-blue-400 text-center mt-24 text-xl">Il y a des concerts</h1>
<?php endif; ?>

<?php require('app/views/partials/footer.php'); ?>