<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Krazy Kart</title>
    <link rel="icon" href="admin/src/img/icon.png" type="image/x-icon">




  <!-- --------------------------------------------Loader Animation----------------------------------------------- -->
  <style>
    #loading-overlay {
      display: flex;
      align-items: center;
      justify-content: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, .5);
      z-index: 9999;
      transition: opacity 1s ease-in
    }

    body {
      margin: 0;
    }

    .cube-container {
      width: 100vw;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      perspective: 1000px;
    }

    div.cube {
      width: 150px;
      height: 150px;
      position: relative;
      transform-style: preserve-3d;
      animation: rotateCubes 3s infinite ease;
    }

    .cube .face {
      position: absolute;
      width: 150px;
      height: 150px;
      background: transparent;
      border: 2px solid red;
      background-size: cover;
      border-radius: 50%;
      background-color: #ffffff;
      overflow: hidden;
    }

    .cube .face:nth-child(1) {
      transform: rotateX(0deg) translateZ(75px);
      background-image: url(assets/public_images/loading-1.jpg);
    }

    .cube .face:nth-child(2) {
      transform: rotateX(90deg) translateZ(75px);
      background-image: url(assets/public_images/loading-2.jpg);
    }

    .cube .face:nth-child(3) {
      transform: rotateX(180deg) translateZ(75px) rotateZ(90deg);
      background-image: url(assets/public_images/loading-4.jpg);
    }

    .cube .face:nth-child(4) {
      transform: rotateX(-90deg) translateZ(75px) rotateZ(90deg);
      background-image: url(assets/public_images/loading-5.jpg);
    }

    .cube .face:nth-child(5) {
      transform: rotateY(-90deg) translateZ(75px) rotateZ(-90deg);
      background-image: url(assets/public_images/loading-3.jpg);
    }

    .cube .face:nth-child(6) {
      transform: rotateY(90deg) translateZ(75px);
      background-image: url(assets/public_images/loading-6.jpg);
    }

    @keyframes rotateCubes {
      0% {
        transform: rotateX(0deg) rotateZ(0deg);
        scale: 1.6;
      }

      5% {
        scale: 2;
      }

      10% {
        transform: rotateX(0deg) rotateZ(0deg);
        scale: 1.6;
      }

      25% {
        transform: rotateX(-90deg) rotateZ(0deg);
      }

      40% {
        transform: rotateX(-90deg) rotateZ(90deg);
      }

      55% {
        transform: rotateX(-180deg) rotateZ(90deg);
      }

      70% {
        transform: rotateX(-270deg) rotateY(-90deg) rotateZ(0deg);
      }

      85% {
        transform: rotateX(-360deg) rotateY(-90deg) rotateZ(0deg);
      }

      100% {
        transform: rotateX(-360deg) rotateZ(0deg) rotateZ(0deg);
        scale: 1.5;
      }
    }
  </style>
  <div id="loading-overlay">
    <div class="cube-container">
      <div class="cube"><i class="face"></i><i class="face"></i><i class="face"></i><i class="face"></i><i
          class="face"></i><i class="face"></i></div>
    </div>
  </div>
  <script>document.addEventListener("DOMContentLoaded", function () { hideLoader() }); function hideLoader() { var e = document.getElementById("loading-overlay"); e.style.opacity = 0, e.style.display = "none" }</script>
  <!-- ----------------------------------------------------Load Animation End--------------------------------------------- -->

  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/jquery_ui.js"></script>
  <!-- ---------------------------Bootstrap 5 -------------------- -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script src="assets/js/bootstrap.js"></script>
  <!-- ---------------------------Bootstrap 5 End ---------------------->

  
  <link rel="stylesheet" href="assets/css/common.css">
  <!-- <link rel="stylesheet" href="assets/css/atlantis.css"> -->
  <!-- <link rel="stylesheet" href="assets/css/atlantis.css"> -->
  <!-- <link rel="stylesheet" href="assets/css/datatable.css"> -->
  <link rel="stylesheet" href="assets/css/animate.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/owl_carousel.css">
  <!-- <script src="assets/js/core/popper.min.js"></script> -->
  <!-- <script src="assets/js/atlantis.js"></script> -->
  <!-- <script src="assets/js/scrollbar.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script> -->
  <!-- <script src="assets/js/datatable.js"></script> -->
  <script src="assets/js/owl_carousel.js"></script>
  <script src="assets/js/sweetalert.js"></script>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"> -->
  <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="assets/js/script.js"></script>
  <script>
    // Reload the page every 5 seconds (adjust the time interval as needed)
    setInterval(function () {
      // location.reload();
    }, 5000);
  </script>
  <script>
    $(document).ready(function () {
      var navbarHeight = $('.navbar').outerHeight();
      $('body').css('padding-top', navbarHeight + 'px');
    });
  </script>
  <script>
    $(document).ready(function () {
      $('.product_card.card').click(function () {
        var productCode = $(this).attr('productCode');
        window.location = 'product?pc=' + productCode;
      });
      $('.category.btn').click(function () {
        var categoryName = $(this).attr('categoryName');
        window.location = 'collection?cn=' + categoryName;
      });
    });
  </script>
  
</head>

<body>
  <div class="background"></div>
  <?php include ('assets/public_function.php');
  include ('conn.php'); ?>

      <?php include ('navbar.php') ?>

        <!-- 
  -------------------------------------Flipkart metas--------------------------------
  <meta name="Keywords" content="Online Shopping in India,online Shopping store,Online Shopping Site,Buy Online,Shop Online,Online Shopping,Flipkart">
  <meta name="Description" content="India's biggest online store for Mobiles, Fashion (Clothes/Shoes), Electronics, Home Appliances, Books, Home, Furniture, Grocery, Jewelry, Sporting goods, Beauty &amp; Personal Care and more! Find the largest selection from all brands at the lowest prices in India. Payment options - COD, EMI, Credit card, Debit card &amp;amp; more.">
  -- -------------------------------------Flipkart metas END--------------------------------


--------------------------------------------------Amazon metas------------------------------
<meta name="description" content="Amazon.in: Online Shopping India - Buy mobiles, laptops, cameras, books, watches, apparel, shoes and e-Gift Cards. Free Shipping &amp; Cash on Delivery Available.">

<meta name="keywords" content="Amazon.in, Amazon, Online Shopping, online shopping india, india shopping online, amazon india, amazn, buy online, buy mobiles online, buy books online, buy movie dvd's online, kindle, kindle fire hd, kindle e-readers, ebooks, computers, laptop, toys, trimmers, watches, fashion jewellery, home, kitchen, small appliances, beauty, Sports, Fitness &amp; Outdoors">
 -----------------------------------------------Amazon metas END------------------------------ 
 *-----------------------------------------shop culture .ca-----------------------------------
 
 
 <meta property="og:url" content="https://shopculture.ca/collections/body-jewelry">
 <meta property="og:description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat n">
 <meta property="og:title" content="Body Jewellery">
 
 
 
 
 
 *-----------------------------------------shop culture .ca END-----------------------------------



















-->