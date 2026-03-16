(function ($) {
    "use strict";

    // Mobile Nav toggle
    const menuToggleLink = $('.menu-toggle > a');
    menuToggleLink.on('click', function (e) {
        e.preventDefault();
        $('#responsive-nav').toggleClass('active');
    });

    // Fix cart dropdown from closing
    const cartDropdown = $('.cart-dropdown');
    cartDropdown.on('click', function (e) {
        e.stopPropagation();
    });

    /////////////////////////////////////////

    // Products Slick initialization
    $('.products-slick').each(function () {
        const $this = $(this);
        const navSelector = $this.attr('data-nav');

        $this.slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            infinite: true,
            speed: 300,
            dots: false,
            arrows: true,
            appendArrows: navSelector || false,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    });

    // Products Widget Slick initialization
    $('.products-widget-slick').each(function () {
        const $this = $(this);
        const navSelector = $this.attr('data-nav');

        $this.slick({
            infinite: true,
            autoplay: true,
            speed: 300,
            dots: false,
            arrows: true,
            appendArrows: navSelector || false,
        });
    });

    /////////////////////////////////////////

    // Product Main Image Slick
    $('#product-main-img').slick({
        infinite: true,
        speed: 300,
        dots: false,
        arrows: true,
        fade: true,
        asNavFor: '#product-imgs',
    });

    // Product Images Slick
    $('#product-imgs').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: 0,
        vertical: true,
        asNavFor: '#product-main-img',
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    vertical: false,
                    arrows: false,
                    dots: true,
                },
            },
        ],
    });

    // Product Image Zoom
    const zoomMainProduct = document.getElementById('product-main-img');
    if (zoomMainProduct) {
        $('#product-main-img .product-preview').zoom();
    }

    /////////////////////////////////////////

    // Input number increment/decrement
    $('.input-number').each(function () {
        const $this = $(this);
        const $input = $this.find('input[type="number"]');
        const up = $this.find('.qty-up');
        const down = $this.find('.qty-down');

        down.on('click', function () {
            let value = parseInt($input.val()) - 1;
            value = Math.max(value, 1);
            $input.val(value).change();
            updatePriceSlider($this, value);
        });

        up.on('click', function () {
            let value = parseInt($input.val()) + 1;
            $input.val(value).change();
            updatePriceSlider($this, value);
        });
    });

    // Price Input handling
    const priceInputMax = document.getElementById('price-max');
    const priceInputMin = document.getElementById('price-min');

    if (priceInputMax && priceInputMin) {
        priceInputMax.addEventListener('change', function () {
            updatePriceSlider($(this).parent(), this.value);
        });

        priceInputMin.addEventListener('change', function () {
            updatePriceSlider($(this).parent(), this.value);
        });
    }

    // Update price slider based on min/max input changes
    function updatePriceSlider(elem, value) {
        if (elem.hasClass('price-min')) {
            priceSlider.noUiSlider.set([value, null]);
        } else if (elem.hasClass('price-max')) {
            priceSlider.noUiSlider.set([null, value]);
        }
    }

    // Price Slider initialization
    const priceSlider = document.getElementById('price-slider');
    if (priceSlider) {
        noUiSlider.create(priceSlider, {
            start: [1, 999],
            connect: true,
            step: 1,
            range: {
                min: 1,
                max: 999,
            },
        });

        priceSlider.noUiSlider.on('update', function (values, handle) {
            const value = values[handle];
            handle ? (priceInputMax.value = value) : (priceInputMin.value = value);
        });
    }
})(jQuery);
