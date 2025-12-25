$(document).ready(function () {

    // Toggle menu on small screens
    $('#menu').click(function () {
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

    // Show login popup
    $('#login').click(function () {
        $('.login-form').addClass('popup');
    });

    // Close login popup
    $('.login-form form .fa-times').click(function () {
        $('.login-form').removeClass('popup');
    });

    // Scroll behavior + active section indicator
    $(window).on('load scroll', function () {

        $('#menu').removeClass('fa-times');
        $('.navbar').removeClass('nav-toggle');

        // Close login popup when scrolling
        $('.login-form').removeClass('popup');

        // Highlight active navbar link
        $('section').each(function () {
            let top = $(window).scrollTop();
            let height = $(this).height();
            let id = $(this).attr('id');
            let offset = $(this).offset().top - 200;

            if (top > offset && top < offset + height) {
                $('.navbar ul li a').removeClass('active');
                $(`.navbar ul li a[href="#${id}"]`).addClass('active');
            }
        });

    });

});
