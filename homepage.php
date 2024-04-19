<?php 
$ActivePage = "home";
include ('header.php'); ?>
<div class="">
    <div class="owl-carousel main owl-theme pt-0">
        <?php

        $itemDetails = getDetails($conn, " 1=1 GROUP BY product_list.category_id ORDER BY product_list.priority", );
        // $itemDetails = getDetails($conn, productsCondition: " 1=1 GROUP BY product_list.category_id ORDER BY product_list.priority", itemCondition: "item_list.visible = 1 ORDER BY item_list.priority LIMIT 1");
        foreach ($itemDetails as $itemDetails) {
            // $itemId = $itemList['item_id'];
            // $itemDetails = getItemDetails($conn, $itemId);
            // if ($itemDetails && $itemDetails['item_images'] != null) {
            // print_r($itemDetails)                                        ?>
            <div class="item d-flex align-items-center justify-content-center"
                style="height:400px;max-height: 50vh; position: relative; overflow: hidden;background-opacity:0.2;background:<?php echo $itemDetails['color_code'] ?>c9">
                <img src="assets/item_images/<?php echo $itemDetails['item_images'][0]; ?>" alt="Slide 1"
                    style="width: auto; height: 100% !important; object-fit: cover; object-position: center;">
                <div class="gradient-overlay d-flex justify-content-center align-items-center"
                    onmouseover="this.classList.add('hovered')" onmouseout="this.classList.remove('hovered')">
                    <div class="text-light text-center mt-5">
                        <div class="text-light display-4 text-center">
                            <?php echo $itemDetails['category_name'] ?>
                        </div>
                        <div class="px-4 h6 d-block"
                            style="width: 450px; max-height: calc(3 * 1.2em); overflow: hidden; text-overflow: ellipsis;">
                            <?php echo $itemDetails['c_description'] ?>
                        </div>
                        <div class="btn category btn-light btn-lg px-5 mt-4"
                            categoryName="<?php echo $itemDetails['category_name'] ?>">Explore More <i
                                class="fa fa-arrow-right"></i></div>
                    </div>
                </div>
            </div>
            <?php
        }
        // }
        // }
        // }                                      ?>
    </div>
    <div>
    </div>
    <div class="my-2 d-flex justify-between ps-2 text-md-center">
        <h3 class="text-sm-end">
            Our Famous Items
        </h3>
        <span class="btn btn-primary bg-pri rounded-0 ms-auto view_collection">View More >></span>
    </div>
    <div class="owl-carousel owl-theme famouse">
        <?php
        // echo print_r(getItemList($conn, "1=1 ORDER BY item_list.priority DESC"));
        // $itemList = getItemList($conn, "1=1 ORDER BY item_list.priority ASC");
        foreach (getDetails($conn, itemCondition: "1=1 GROUP BY product_id ORDER BY item_list.priority ASC,product_list.priority") as $itemDetails) {
            if ($itemDetails['item_images'] != null) {
                // for ($i = 0; $i < 1000000; $i++) {
                ?>
                <div class="item">
                    <div class="card product_card border-3 border border-white p-1"
                        productCode="<?php echo $itemDetails['product_code'] ?>">
                        <span style="z-index:1" class="ms-2 h4 text-pri addFavourite position-absolute">
                            <i class="fas text-sec fa-heart"></i>
                            <!-- <i class="far fa-heart"></i> -->
                        </span>
                        <div class="image-container rounded-1 overflow-hidden">
                            <div class="loading-animation image<?php echo $itemDetails ?>"></div>
                            <img User loading="lazy" src="assets/item_images/<?php echo $itemDetails['item_images'][0]; ?>"
                                onerror="$(this).hide();$('.image<?php echo $i ?>').show()" class="">
                        </div>
                        <div class="bg-white itemDetail">
                            <div style="height:3em" class="small">
                                <?php echo $itemDetails['product_name'] ?> (
                                <?php echo $itemDetails['color_name'] ?>)
                            </div>
                            <div class="row">
                                <div class="col-7 text-acc" style="font-size:20px">
                                    <div class="rating-container">
                                        <div class="rating-star bg-acc"></div>
                                        <div class="rating-level bg-sec" style="width:50px"></div>
                                    </div>
                                    <small><i class="fa fa-comment-dots text-pri"></i>(122)</small>
                                </div>
                                <div class="text-end col-5">
                                    <sub class="h6 text-sec"> <del>₹
                                            <?php echo $itemDetails['mrp'] ?>
                                        </del></sub>
                                    <div class="h5 text-pri"> ₹<span>
                                            <?php echo $itemDetails['price'] ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="row ps-3 pe-0 moreDetails text-sec" style="dissplay:one">
                                    <div class="col-6">
                                        <small><i class="fa fa-ruler text-pri"></i>
                                            <?php
                                            echo count(getDetails($conn, itemCondition: "1=1"))
                                                // echo count(getDetails($conn, itemCondition: "1=1 GROUP BY size_id", productsCondition: "product_id = " . $itemDetails['product_id']))  ?>

                                            Size
                                        </small>
                                    </div>
                                    <div class="col-6 text-end">
                                        <?php
                                        echo count(getDetails($conn, $itemDetails['product_id'])) 

                                        // echo count(getDetails($conn, itemCondition: "1=1 GROUP BY color_id", productsCondition: "product_id = " . $itemDetails['product_id'])) ?>
                                        Color
                                        <span class="" style="font-size:9px">
                                            <i class="fa fa-circle text-pri"></i>
                                            <i class="fa fa-circle text-sec"></i>
                                            <span>
                                                <i class="fa fa-circle text-acc"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn btn-primary bg-pri text-nue w-100">
                            MORE DETAILS <i class="fas fa-arrow-circle-right"></i>
                        </div>
                        <div>
                            <div class="form-switch">
                                <div class="form-check-reverse">
                                    <div class="form-check-reverse"></div>
                                </div>
                            </div>
                        </div>
                        <div class="btn btn-danger bg-sec mt-2 w-100"> ADD TO WISHCART <i class="fa fa fa-cart-plus"></i>
                        </div>
                    </div>
                    <!-- </a> -->
                </div>
            <?php }
            // }
        }
        ?>
    </div>
    <hr>
    <hr>
    <hr>
    <script>
        $(document).ready(function () {
            $('.owl-carousel.famouse .card').hover(
                function () {
                    $(this).addClass("hovered");
                },
                function () {
                    $(this).removeClass("hovered");
                }
            );
        });
        // $(document).ready(function () {
        //     $('.owl-carousel.famouse .card').on('mouseenter', function () {
        //         $(this).find(".moreDetails").slideDown({ direction: "down" });
        //         $(this).find(".itemDetail").css("transform", "translateY(-50px);transition:2s");
        //     }).on('mouseleave', function () {
        //         $(this).find(".moreDetails").slideUp({ direction: "up" });
        //         $(this).find(".itemDetail").css("transform", "none");
        //     });
        // });
    </script>
    <script>
        $(document).ready(function () {
            function isElementInViewport(elem) {
                var rect = elem.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }

            var box = $(".gradient-overlay");
            var hovered = false;

            $(window).on("scroll load", function () {
                if (isElementInViewport(box[0])) {
                    if (!hovered) {
                        setTimeout(function () {
                            box.addClass("hovered");
                        }, 2000);
                        hovered = true;
                    }
                } else {
                    hovered = false;
                    box.removeClass("hovered");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel.main').owlCarousel({
                loop: false,
                margin: 5,
                nav: true,
                autoplay: true,
                // freeDrag: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                nav: false,
                // center: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    800: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                },
                lazyLoad: true,
                onInitialized: function (event) {
                    $('.owl-item.active .loading-animation').hide();
                },
                onLazyLoaded: function (event) {
                    $('.owl-item.active .gradient-overlay').css('opacity', 1);
                }
            });
            $('.owl-carousel.famouse').owlCarousel({
                loop: false,
                margin: 5,
                nav: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                URLhashListener: true,
                startPosition: 'URLHash',
                autoplaySpeed: 1000,
                dots: false,
                scroll: true,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    300: {
                        center: true,
                        items: 1.5

                    },
                    600: {
                        items: 2
                    },
                    900: {
                        items: 3
                    },
                    1200: {
                        items: 5
                    }
                },
                onTranslate: function (event) {
                    var currentItemIndex = event.item.index;
                    var totalItems = event.item.count;

                    // Check if the current item is the last one
                    if (currentItemIndex === totalItems - 1) {
                        $('.owl-stage').css('transform', 'translate3d(10%, 0px, 0px)');
                    }
                }
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            // Iterate over each image container
            $('.image-container').each(function () {
                var $imgContainer = $(this);
                var $loadingAnimation = $imgContainer.find('.loading-animation');
                var $img = $imgContainer.find('img');

                // Check if the image is loaded successfully
                $img.on('load', function () {
                    // Show the image and hide the loading animation
                    $img.show();
                    $loadingAnimation.hide();
                }).on('error', function () {
                    // If the image fails to load, hide the image and show the loading animation
                    $img.hide();
                    $loadingAnimation.show();
                });
            });
        });
    </script>
</div>

<?php include ('footer.php'); ?>