
// function which can redirect to given url in div on click on it
$(document).on('click', 'div[href], div[hrep]', function () {
    var href = $(this).attr("href");
    var hrep = $(this).attr("hrep"); // Get the value of 'hrep' attribute
    if (hrep) { 
        location.replace(hrep);
    } else if (href) {
        var target = $(this).attr("target");
        if (target === "_blank") {
            window.open(href, '_blank');
        } else {
            location.replace(href);
        }
    }
});
$('.fullscreen-image').on('click', function () {
    $(document).ready(function () {
        $('.fullscreen-image').click(function () {
            var images = $('.fullscreen-image');
            var index = images.index(this);

            $('#fullscreenModal .carousel-inner').empty();
            images.each(function (i) {
                var imgSrc = $(this).attr('src');
                var itemClass = (i === index) ? 'carousel-item active' : 'carousel-item';
                var imgHtml = '<div class="' + itemClass + '"><img src="' + imgSrc + '" class="d-block w-100"></div>';
                $('#fullscreenModal .carousel-inner').append(imgHtml);
            });

            $('#fullscreenModal').modal('show');
        });
    });
});