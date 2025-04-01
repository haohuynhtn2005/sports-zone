
// Start Window Load Function
$(window).on('load', function() {

    'use strict';

    $('.hero-slider').ready(function(){
        $(this).find('.slick-arrow').append('<span></span>')
    });

    // Check android devices OS system if they are older than 4.4
    var ua = navigator.userAgent;
    if( ua.indexOf("Android") >= 0 ) {
        var androidversion = parseFloat(ua.slice(ua.indexOf("Android")+8)),
            wHeight = $(window).height();
        if (androidversion < 4.9) {
            $(".home").css({"height": wHeight + "px"});
        }
    }
        // init cubeportfolio
        $('#portfolio-items').cubeportfolio({
            filters: '#filter1, #filter2',
            layoutMode: 'grid',
            mediaQueries: [{
                width: 1500,
                cols: 4,
            }, {
                width: 800,
                cols: 3,
            }, {
                width: 600,
                cols: 2,
            }, {
                width: 480,
                cols: 1,
                options: {
                    caption: '',
                }
            }],
            defaultFilter: '*',
            animationType: 'scaleDown',
            gapHorizontal: 40,
            gapVertical: 15,
            gridAdjustment: 'responsive',
            caption: 'zoom',
            displayType: 'sequentially',
            displayTypeSpeed: 10,
        });

        // init cubeportfolio
        $('#gallery-items').cubeportfolio({
            filters: '#gallery-filter1, #gallery-filter2',
            loadMore: '#js-loadMore-masonry-projects',
            loadMoreAction: 'click',
            layoutMode: 'grid',
            defaultFilter: '*',
            animationType: 'quicksand',
            gapHorizontal: 15,
            gapVertical: 15,
            gridAdjustment: 'responsive',
            mediaQueries: [{
                width: 1500,
                cols: 4,
            }, {
                width: 1100,
                cols: 4,
            }, {
                width: 800,
                cols: 3
            }, {
                width: 480,
                cols: 1,
                options: {
                    caption: '',
                    gapHorizontal: 25,
                    gapVertical: 10,
                }
            }],
            caption: 'zoom',
            displayType: 'fadeIn',
            displayTypeSpeed: 100,

            // lightbox
            lightboxDelegate: '.cbp-lightbox',
            lightboxGallery: true,
            lightboxTitleSrc: 'data-title',
            lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

            // singlePage popup
            singlePageDelegate: '.cbp-singlePage',
            singlePageDeeplinking: true,
            singlePageStickyNavigation: true,
            singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
            singlePageCallback: function(url, element) {
                // to update singlePage content use the following method: this.updateSinglePage(yourContent)
                var t = this;

                $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'html',
                        timeout: 30000
                    })
                    .done(function(result) {
                        t.updateSinglePage(result);
                    })
                    .fail(function() {
                        t.updateSinglePage('AJAX Error! Please refresh the page!');
                    });
            },
        });


// End Function
});