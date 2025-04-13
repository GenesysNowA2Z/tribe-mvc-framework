<?php
    use app\core\Application;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="<?php echo url(); ?>/resources/images/logos/logo-icon.svg" />

    <!-- Core Css -->
    <link rel="stylesheet" href="<?php echo url(); ?>/resources/css/styles.css" />
    <title><?php echo $this->title; ?></title>
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="<?php echo url(); ?>/resources/libs/owl.carousel/dist/resources/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?php echo url(); ?>/resources/libs/aos/dist/aos.css" />
</head>

<body class="overflow-x-hidden">
<!-- Preloader -->
<div class="preloader">
    <img src="<?php echo url(); ?>/resources/images/logos/logo-icon.svg" alt="loader" class="lds-ripple img-fluid" />
</div>

<!--Main-wrapper-->
<div class="landingpage">
    <div class="main-wrapper">
        <header class="topheader py-3" id="top">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light ps-0">
                    <!-- Logo will be here -->
                    <a class="navbar-brand" href="<?php echo url(); ?>/landingpage/index.html">
                        <img src="<?php echo url(); ?>/resources/images/landingpage/logo-icon.png" alt="logo" />
                        <img src="<?php echo url(); ?>/resources/images/landingpage/logo-text.png" alt="logo" />
                    </a>

                    <!--Toggle button-->
                    <button class="navbar-toggler navbar-toggler-right border-0 p-0 fs-8" type="button" data-bs-toggle="offcanvas" href="#right-sidebar">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone"></iconify-icon>
                    </button>

                    <!-- This is the navigation menu -->
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-auto stylish-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="https://docs.genesysnow.io" target="_blank">Documentation</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <!-- mobile sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="right-sidebar" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

        </div>

        <!-- start banner -->
        <div class="banner">
            <div class="container banner-content">
                <div class="row justify-content-between">
                    <div class="col-lg-8 col-xl-5 d-flex align-items-center">
                        <div>
                            <h1 class="mb-3 pb-3 fw-bolder banner-title" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                                <span class="text-primary-grediant">Security First,</span>
                                Everything Else Next
                            </h1>

                            <a href="https://docs.genesysnow.io" target="_blank" class="btn bg-white shadow-sm btn-lg rounded-pill">Learn More</a>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-6 d-none d-xl-flex align-items-center">
                        <div class="row">
                            <div class="col-md-4">
<!--                                <img src="--><?php //echo url(); ?><!--/resources/images/landingpage/banner-widget-1.png" alt="widget1" class="img-fluid rounded-3 img-shadow" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" />-->
<!--                                <img src="--><?php //echo url(); ?><!--/resources/images/landingpage/banner-widget-3.png" alt="widget1" class="img-fluid rounded-3 img-shadow mt-4" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" />-->
<!--                                <img src="--><?php //echo url(); ?><!--/resources/images/landingpage/banner-widget-5.png" alt="widget1" class="img-fluid rounded-3 img-shadow mt-4" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000" />-->
                            </div>
                            <div class="col-md-8 mt-4">
<!--                                <img src="--><?php //echo url(); ?><!--/resources/images/landingpage/banner-widget-2.png" alt="widget1" class="img-fluid rounded-3 img-shadow" data-aos="fade-up" data-aos-delay="800" data-aos-duration="1000" />-->
<!--                                <img src="--><?php //echo url(); ?><!--/resources/images/landingpage/banner-widget-4.png" alt="widget1" class="img-fluid rounded-3 img-shadow my-4" data-aos="fade-up" data-aos-delay="900" data-aos-duration="1000" />-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end banner -->
        <div class="text-bg-primary py-5">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-7 col-xl-5 pt-lg-5 mb-5 mb-lg-0">
                        <h2 class="fs-8 text-white text-center text-lg-start fw-bold mb-7">
                            Build your app with our secure, scalable and intuitive Tribe Framework
                        </h2>
                        <div class="d-sm-flex align-items-center justify-content-center justify-content-lg-start gap-3">
                            <a href="https://docs.genesysnow.io" class="btn bg-white text-primary fw-semibold d-block mb-3 mb-sm-0 btn-hover-shadow px-7 py-6">Get Started</a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-5">
                        <div class="text-center text-lg-end mb-n3">
                            <img src="<?php echo url(); ?>/resources/images/landingpage/business-woman-checking-her-mail.png" alt="adminpro-img" class="img-fluid mb-n5" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->

        <!-- start footer -->
        <footer class="text-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
              <span>
                <img src="<?php echo url(); ?>/resources/images/landingpage/logo-icon.png" alt="logo" />
              </span>
                        <div class="mt-2">
                <span>All rights reserved by Genesys Now. Designed & Developed by
                  <a href="https://www.genesysnow.io/" class="text-primary">Genesys Now</a>
                </span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!--End of main wrapper-->

<div class="dark-transparent sidebartoggler"></div>
<!-- Import Js Files -->
<!-- Import Js Files -->
<script src="<?php echo url(); ?>/resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo url(); ?>/resources/libs/simplebar/dist/simplebar.min.js"></script>
<script src="<?php echo url(); ?>/resources/js/theme/app.init.js"></script>
<script src="<?php echo url(); ?>/resources/js/theme/theme.js"></script>
<script src="<?php echo url(); ?>/resources/js/theme/app.min.js"></script>
<script src="<?php echo url(); ?>/resources/js/theme/feather.min.js"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="<?php echo url(); ?>/resources/libs/aos/dist/aos.js"></script>
<script>
    // Aos
    AOS.init({
        once: true,
    });
</script>
</body>

</html>