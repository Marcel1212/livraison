<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
?>

<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-start d-block d-md-inline-block mt-25">Copyright &copy; <?= date('Y') ?>
            <a class="ms-25" href="#" target="_blank"><?php echo @$logo->titre_logo;?></a>
            <span class="d-none d-sm-inline-block">, Tous  droits  réservés</span>
        </span>
        <?php if(isset($logo->mot_cle)){?>
            <span class="float-md-end d-none d-md-block"><?php echo $logo->mot_cle;?> <img width="35" height="35" src="{{ asset('/frontend/logo/'. @$logo->logo_logo)}}"></span>
        <?php } ?>

    </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>


