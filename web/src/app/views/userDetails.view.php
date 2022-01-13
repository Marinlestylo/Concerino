<?php require('app/views/partials/header.php'); ?>
<?php require('app/views/partials/nav.php'); ?>

<h1 class="text-blue-400 text-center mt-24 text-5xl">Détails utilisateur 
    <?php if(isset($_GET['id'])): ?>
    <?= $_GET['id'] ?>
    <?php else: ?>
        rien
    <?php endif; ?>
</h1>


<?php require('app/views/partials/footer.php'); ?>