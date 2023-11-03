<?php

use App\Helpers\Menu;

$logo = Menu::get_logo();
?>


<footer class="content-footer footer bg-footer-theme ">
    <div class="container-fluid">
        <div
            class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                © 2023 -
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , <a href="#" target="_blank" class="fw-medium">FDFP</a>
            </div>
            <div class="d-none d-lg-inline-block">
                Design by
                <a href="#" class="footer-link me-4" target="_blank">Barnoin informatique </a>
            </div>
        </div>
    </div>
</footer>
