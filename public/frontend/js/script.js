(function ($) {
    "use strict";

    /*======================================
     ScrollIT
     ======================================*/
    $.scrollIt({
        upKey: 60, // key code to navigate to the next section
        downKey: 40, // key code to navigate to the previous section
        easing: "linear", // the easing function for animation
        scrollTime: 600, // how long (in ms) the animation takes
        activeClass: "active", // class given to the active nav element
        onPageChange: null, // function(pageIndex) that is called when page is changed
        topOffset: -70, // offste (in px) for fixed top navigation
    });

    /*======================================
     WOW Animation
     ======================================*/
    var wow = new WOW({
        boxClass: "wow", // animated element css class (default is wow)
        animateClass: "animated", // animation css class (default is animated)
        offset: 0, // distance to the element when triggering the animation (default is 0)
        mobile: false, // trigger animations on mobile devices (default is true)
        live: true, // act on asynchronously loaded content (default is true)
        callback: function (box) {},
        scrollContainer: true, // optional scroll container selector, otherwise use window
    });
    wow.init();

    $(".home-slider").owlCarousel({
        responsiveClass: true,
        nav: false,
        dots: true,
        animateOut: "fadeOut",
        autoplay: 3000,
        autoplayTimeout: 3000,
        smartSpeed: 3000,
        paginationSpeed: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1200: {
                items: 1,
            },
        },
    });
    $(".home-categories").owlCarousel({
        loop: true,
        responsiveClass: true,
        nav: false,
        dots: true,
        margin: 20,
        navText: [
            '<span class="ti-angle-left"></span>',
            '<span class="ti-angle-right"></span>',
        ],
        animateOut: "fadeOut",
        smartSpeed: 300,
        paginationSpeed: 300,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 2,
            },
            1200: {
                items: 7,
            },
        },
    });
    $(".home-products").owlCarousel({
        loop: true,
        responsiveClass: true,
        nav: true,
        dots: false,
        animateOut: "fadeOut",
        margin: 20,
        navText: [
            '<span class="ti-angle-left"></span>',
            '<span class="ti-angle-right"></span>',
        ],
        smartSpeed: 300,
        paginationSpeed: 300,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 2,
            },
            1200: {
                items: 5,
            },
        },
    });
    $(".product-imgs").owlCarousel({
        loop: true,
        responsiveClass: true,
        nav: true,
        dots: true,
        animateOut: "fadeOut",
        navText: [
            '<span class="ti-angle-left"></span>',
            '<span class="ti-angle-right"></span>',
        ],
        smartSpeed: 300,
        paginationSpeed: 300,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1200: {
                items: 1,
            },
        },
    });
    /*======================================
     Preloader
     ======================================*/
    $("#preloader").fadeOut("slow", function () {
        $(this).remove();
    });
    $(".select2").select2();
    $(".single-select").select2({
        minimumResultsForSearch: -1,
    });
    $(".heart").on("click", function () {
        $(this).toggleClass("active");
    });
    $(".addtowishlist").on("click", function () {
        $(this).toggleClass("active");
    });
    $(".smoothscroll").mCustomScrollbar({
        advanced: {
            updateOnContentResize: true,
        },
        scrollButtons: {
            enable: false,
        },
        mouseWheelPixels: "100",
        theme: "dark-2",
    });

    //Slider range price
    $(".slider-range-price").each(function () {
        var min = parseInt($(this).data("min"));
        var max = parseInt($(this).data("max"));
        var unit = $(this).data("unit");
        var value_min = parseInt($(this).data("value-min"));
        var value_max = parseInt($(this).data("value-max"));
        var label_reasult = $(this).data("label-reasult");
        var t = $(this);
        $(this).slider({
            range: true,
            min: min,
            max: max,
            values: [value_min, value_max],
            slide: function (event, ui) {
                var result =
                    label_reasult +
                    " <span>" +
                    ui.values[0] +
                    unit +
                    " </span>  <span> " +
                    ui.values[1] +
                    unit +
                    "</span>";
                t.closest(".price_slider_wrapper")
                    .find(".price_slider_amount")
                    .html(result);
            },
        });
    });
    $(".categories-content").each(function () {
        $(".show-sub").children(".children").show();
        var main = $(this);
        main.children(".cat-parent").each(function () {
            var curent = $(this).find(".children");
            $(this)
                .children(".arrow-cate")
                .on("click", function () {
                    $(this).parent().toggleClass("show-sub");
                    $(this).parent().children(".children").slideToggle(400);
                    main.find(".children").not(curent).slideUp(400);
                    main.find(".cat-parent")
                        .not($(this).parent())
                        .removeClass("show-sub");
                });
            var next_curent = $(this).find(".children");
            next_curent.children(".cat-parent").each(function () {
                var child_curent = $(this).find(".children");
                $(this)
                    .children(".arrow-cate")
                    .on("click", function () {
                        $(this).parent().toggleClass("show-sub");
                        $(this)
                            .parent()
                            .parent()
                            .find(".cat-parent")
                            .not($(this).parent())
                            .removeClass("show-sub");
                        $(this)
                            .parent()
                            .parent()
                            .find(".children")
                            .not(child_curent)
                            .slideUp(400);
                        $(this).parent().children(".children").slideToggle(400);
                    });
            });
        });
    });
    $(".sp-wrap").smoothproducts();
    $("#showPass").on("click", function () {
        var passInput = $("#passInput");
        if (passInput.attr("type") === "password") {
            passInput.attr("type", "text");
            $(this).addClass("active");
        } else {
            passInput.attr("type", "password");
            $(this).removeClass("active");
        }
    });
    $("#showPass2").on("click", function () {
        var passInput = $("#passInput2");
        if (passInput.attr("type") === "password") {
            passInput.attr("type", "text");
            $(this).addClass("active");
        } else {
            passInput.attr("type", "password");
            $(this).removeClass("active");
        }
    });


    $(".time-block").on("click", function (e) {
        $(".time-block").not(this).removeClass("active");
        $(this).toggleClass("active");
    });
    $(".pro-size .sizebtn").on("click", function (e) {
        $(".pro-size .sizebtn").not(this).removeClass("active");
        $(this).toggleClass("active");
    });
    $(".pro-color .sizebtn").on("click", function (e) {
        $(".pro-color .sizebtn").not(this).removeClass("active");
        $(this).toggleClass("active");
    });
    $(".search-categories .btn").on("click", function (e) {
        $(this).toggleClass("active");
    });

    $(document).on("click", ".cart-btn", function (e) {
        e.preventDefault();
        $(".user-side-modal").addClass("is-open");
        $("#body-overlay").addClass("active");
    });
    $(document).on("click", ".search-btn", function (e) {
        e.preventDefault();
        $(".search-modal").addClass("is-open");
        $("#body-overlay").addClass("active");
    });
    $(document).on("click", ".side-menu", function (e) {
        e.preventDefault();
        $(".menu-modal").addClass("is-open");
        $("#body-overlay").addClass("active");
    });
    $(document).on("click", ".filter-btn", function (e) {
        e.preventDefault();
        $(".content-sidebar").addClass("is-open");
        $("#body-overlay").addClass("active");
    });
    $(document).on("click", ".close-modal", function (e) {
        e.preventDefault();
        $(".content-sidebar").removeClass("is-open");
        $("#body-overlay").removeClass("active");
    });
    $(document).on("click", ".menu-responsive", function (e) {
        e.preventDefault();
        $(".main-menu").addClass("is-open");
        $("#body-overlay").addClass("active");
    });
    $(document).on("click", ".close-modal", function (e) {
        e.preventDefault();
        $(".main-menu").removeClass("is-open");
        $("#body-overlay").removeClass("active");
    });
    $(document).on("click", ".order-summery > h2", function (e) {
        e.preventDefault();
        $(".cart-summery-content").addClass("is-open");
        $("#body-overlay").addClass("active");
    });
    $(document).on("click", ".close-modal", function (e) {
        e.preventDefault();
        $(".cart-summery-content").removeClass("is-open");
        $("#body-overlay").removeClass("active");
    });
    $(document).on("click", "#body-overlay, .close-modal", function (e) {
        e.preventDefault();
        $("#body-overlay").removeClass("active");
        $(".user-side-modal").removeClass("is-open");
        $(".search-modal").removeClass("is-open");
        $(".menu-modal").removeClass("is-open");
        $(".main-menu").removeClass("is-open");
        $(".cart-summery-content").removeClass("is-open");
        $(".content-sidebar").removeClass("is-open");
    });
    $(document).on("click", ".quantity .plus, .quantity .minus", function (e) {
        // Get values
        var $qty = $(this).closest(".quantity").find(".qty"),
            currentVal = parseFloat($qty.val()),
            max = parseFloat($qty.attr("max")),
            min = parseFloat($qty.attr("min")),
            step = $qty.attr("step");
        // Format values
        if (!currentVal || currentVal === "" || currentVal === "NaN")
            currentVal = 0;
        if (max === "" || max === "NaN") max = "";
        if (min === "" || min === "NaN") min = 0;
        if (
            step === "any" ||
            step === "" ||
            step === undefined ||
            parseFloat(step) === "NaN"
        )
            step = 1;
        // Change the value
        if ($(this).is(".plus")) {
            if (max && (max == currentVal || currentVal > max)) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }
        } else {
            if (min && (min == currentVal || currentVal < min)) {
                $qty.val(min);
            } else if (currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }
        }
        // Trigger change event
        $qty.trigger("change");
        e.preventDefault();
    });
    if ($("#phone").length) {
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript: "js/utils.js",
            initialCountry: "kw",
        });
    }
    $(".mySelect2").select2({
        dropdownParent: $("#exampleModalLong"),
    });
    $(".choose-time-date").on("click", function () {
        $(".choose-time").addClass("active");
    });
    $(".choose-asap").on("click", function () {
        $(".choose-time").removeClass("active");
    });
    //    $(function () {
    //        var availableTags = [
    //            "ActionScript",
    //            "AppleScript",
    //            "Asp",
    //            "BASIC",
    //            "C",
    //            "C++",
    //            "Clojure",
    //            "COBOL",
    //            "ColdFusion",
    //            "Erlang",
    //            "Fortran",
    //            "Groovy",
    //            "Haskell",
    //            "Java",
    //            "JavaScript",
    //            "Lisp",
    //            "Perl",
    //            "PHP",
    //            "Python",
    //            "Ruby",
    //            "Scala",
    //            "Scheme"
    //        ];
    //        $("#tags").autocomplete({
    //            source: availableTags,
    //        });
    //        $("#tags").autocomplete("option", "appendTo", ".eventInsForm");
    //
    //    });
    var $window = $(window);
    $window.on("scroll", function () {
        if ($window.scrollTop() > 0) {
            $(".categories-restraunt").addClass("sticky");
        } else {
            $(".categories-restraunt").removeClass("sticky");
        }
    });
    $(".print").on("click", function () {
        $.print(".order-details-content");
    });
})(jQuery);