<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white display-6 d-md-block" href="/">KrazyKart</a>
        <div class="search-bar-container w-auto">
            <div class="input-group rounded-5" style="height:40px">
                <div class="input-group-text border-2 border-end-0 border-danger rounded-start-3">
                    <i class="fas fa-search text-sec"></i>
                </div>
                <input type="text" placeholder="Search Category, Type and More..."
                    class="form-control searchInput rounded-end-3 border-2 border-danger border-start-0 ">
            </div>
        </div>
        <div class="btn text-white border-1 ms-auto d-md-none me-1 search-icon"><i class="fas fa-search"></i></div>
        <div class="btn text-white border-1 me-1" href="wishkart"><i class="fas fa-shopping-cart" ></i></div>
    </div>
</nav>

<!-- Search Bar -->
<?php
if (!in_array(@$ActivePage, ['product'])) {


    ?>
    <nav class="navbar navbar-light bg-light fixed-bottom">
        <ul class="nav nav-tabs nav-fill mx-auto mb-lg-0">
            <li class="nav-item">
                <a class="nav-link <?php echo $ActivePage == 'home' ? 'active' : '' ?>" href="/"><span><i
                            class="fas fa-home"></i></span> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $ActivePage == 'collection' ? 'active' : '' ?>" href="collection"><span><i
                            class="fas fa-box"></i></span> Collection</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $ActivePage == 'orders' ? 'active' : '' ?>" href="#"><span><i
                            class="fas fa-shopping-cart"></i></span> Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $ActivePage == 'rewards' ? 'active' : '' ?>" href="#"><span><i
                            class="fas fa-gift"></i></span> Reward</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $ActivePage == 'profile' ? 'active' : '' ?>" href="login"><span><i
                            class="fas fa-user"></i></span> Profile</a>
            </li>
        </ul>
    </nav>
    <?php
} ?>

<script>
    $(document).ready(function () {
        $('.search-icon').click(function () {
            $('.search-bar-container').toggle();
        });
    });
</script>
<style>
    .searchInput.form-control{
        border-top: 2px solid var(--sec) !important;
        border-bottom: 2px solid var(--sec) !important;
        border-right: 2px solid var(--sec) !important;

    }
    .searchInput.form-control:focus {
        box-shadow: none;
    }

    .search-bar-container {
        display: block;
    }

    @media (max-width: 767px) {
        .search-bar-container {
            display: none;
            position: fixed;
            top: 56px;
            /* Adjust top position based on your navbar height */
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: #f8f9fa;
            padding: 8px;
            /* border-radius: 8px; */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    }

    @media (min-width: 992px) {
        .search-bar-container {
            /* display: none; */
        }
    }

    /* .search-bar {
    display: flex;
    align-items: center;
} */
</style>

<script>
    $(document).ready(function () {
        var lastScrollTop = 0;
        var delta = 50; // Minimum number of pixels scrolled to trigger the scroll event
        var navbarTopVisible = true;
        var navbarBottomVisible = true;
        var scrollDirection;

        $(window).scroll(function (event) {
            var st = $(this).scrollTop();

            // Scroll down
            if (st > lastScrollTop) {
                scrollDirection = 'down';
                // If scrolled more than delta pixels, hide top navbar
                // if (Math.abs(st - lastScrollTop) > delta && navbarTopVisible) {
                //     $('.navbar.fixed-top').fadeOut('slow');
                //     navbarTopVisible = false;
                // }
                // If scrolled more than delta pixels, show bottom navbar if hidden
                if (Math.abs(st - lastScrollTop) > delta && !navbarBottomVisible) {
                    $('.navbar.fixed-bottom').removeClass('animate__animated animate__fadeOutDown').fadeIn('slow');
                    //  $('.navbar.fixed-bottom').addClass('animate__animated animate__fadeOutDown').fadeOut('slow');
                    navbarBottomVisible = true;
                }
            }
            // Scroll up
            else {
                scrollDirection = 'up';
                // If scrolled more than delta pixels, show top navbar if hidden
                // if (Math.abs(st - lastScrollTop) > delta && !navbarTopVisible) {
                //     $('.navbar.fixed-top').fadeIn('slow');
                //     navbarTopVisible = true;
                // }
                // If scrolled more than delta pixels, hide bottom navbar
                if (Math.abs(st - lastScrollTop) > delta && navbarBottomVisible) {
                    // $('.navbar.fixed-bottom').removeClass('animate__animated animate__fadeOutDown').fadeIn('slow');
                    $('.navbar.fixed-bottom').addClass('animate__animated animate__fadeOutDown').fadeOut('slow');
                    navbarBottomVisible = false;
                }
            }

            lastScrollTop = st;
        });
    });

</script>