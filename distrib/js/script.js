/*

    1. слайдеры 
        1.1 промо-блок
        1.2 отзывы
        1.3 обучение
        1.4 блог/новости
    2. появления
    3. меню
        3.1 логика
        3.2 закрытие на esc
    4. форма
    5. прелоадер
    6. параллакс
    7. прилипающий хедер
    8. возможно пригодится

*/



$(document).ready(function(){


// 1. слайдеры
// ==============

    // 1.1 промо-блок
    // -----------------

        // логика:
        // Запускается разбор слайда - элементы уезжают с экрана
        // Вызывается смена слайда с нулевым временем перехода (мгновенно)
        // Новый слайд собирается - элементы появляются на экране


        // на больших экранах отключаем свайп пальцем, на малых включаем
        if ($( window ).width() > 768) {
            var heroSwiper = new Swiper('.swiper-hero', {
              speed: 0,
              touchRatio: 0,
            });
        } else {
            var heroSwiper = new Swiper('.swiper-hero', {
              speed: 400,
            });
        }

        // разобрать слайд до свайпа
        function breakSlide() {
            $('.hero').addClass('up');
            $('.swiper-slide').find('.hero__slide-number, .hero__info h1, .hero__info p, .hero__info a, .hero__img').addClass('up');
            console.log('break slide');
        }

        // собрать слайд после свайпа
        function makeupSlide() {
            $('.hero').removeClass('up');
            $('.swiper-slide').find('.hero__slide-number, .hero__info h1, .hero__info p, .hero__info a, .hero__img').removeClass('up');
            console.log('make slide');
        }

        // свайп влево-справо
        function slideNext() { 
            heroSwiper.slideNext(0);
            makeupSlide(); 
        }
        function slidePrev() { 
            heroSwiper.slidePrev(0);
            makeupSlide(); 
        }


        // триггеры
        $('.js-slide-next').click(function() {
            $(this).parent().find('.arrow_active').removeClass('arrow_active');
            $(this).parent().find('.bullet_active').removeClass('bullet_active');
            $(this).parent().next().find('.arrow').addClass('arrow_active');
            $(this).parent().next().find('.bullet').addClass('bullet_active');
            breakSlide();
            setTimeout(slideNext, 950);
        });

        $('.js-slide-prev').click(function() {
            $(this).parent().find('.arrow_active').removeClass('arrow_active');
            $(this).parent().find('.bullet_active').removeClass('bullet_active');
            $(this).parent().prev().find('.arrow').addClass('arrow_active')
            $(this).parent().prev().find('.bullet').addClass('bullet_active');
            breakSlide();
            setTimeout(slidePrev, 950);
        });

        $('.js-slide-to-me').click(function(event) {
            var me = $(this);
            var myNum = me.attr('data-slide-to');

            // если нажат текщущий слайд, ничего не происходит
            if(me.hasClass('bullet_active')) {
                return false;
            } else {
                breakSlide();

                $('.bullet').removeClass('bullet_active');
                me.addClass('bullet_active');

                $('.arrow').removeClass('arrow_active');
                me.parent().find($('.arrow')).addClass('arrow_active');

                function slideToMe() {
                    heroSwiper.slideTo(myNum, 0);
                    makeupSlide();
                }

                setTimeout(slideToMe, 950);
            }
        });



    // 1.2 отзывы
    // -----------------


        var feedbackSwiper = new Swiper('.swiper-feedback', {
          speed: 800,
            navigation: {
                nextEl: '.swiper-feedback__btn-next',
                prevEl: '.swiper-feedback__btn-prev',
            },
        });



    // 1.3 обучение
    // -----------------


        var teachingSwiper = new Swiper('.swiper-teaching', {
          speed: 300,
          pagination: {
            clickable: true,
            el: '.teaching-pagination',
          },
        });



    // 1.4 блог/новости
    // -----------------


        // логика:

        // Запускается закрытие новостей "шторками"
        // Вызывается смена слайда с нулевым временем перехода (мгновенно)
        // убираем "шторки"


        // на больших экранах отключаем свайп пальцем, на малых включаем
        if ($( window ).width() > 768) {
            var newsSwiper = new Swiper('.swiper-container-news', {
              slidesPerView: 1,
              spaceBetween: 30,
                touchRatio: 0,
            });
        } else {
            var newsSwiper = new Swiper('.swiper-container-news', {
              slidesPerView: 1,
              spaceBetween: 30,
             });
        }


        var newsAnimationFinished = true; 

            // шторка до свайпа
            function shrinkSlide() {
                $('.news-item').addClass('shrink');

                newsAnimationFinished = true;
            }

            // шторка после свайпа
            function enlargeSlide() {
                $('.news-item').removeClass('shrink');
                newsAnimationFinished = true;
            }

            // свайп влево-справо
            function slideNewsNext() { 
                newsSwiper.slideNext(0);
                setTimeout(enlargeSlide, 400);
            }
            function slideNewsPrev() { 
                newsSwiper.slidePrev(0);
                setTimeout(enlargeSlide, 400);
            }
        

        function newsPrev() {
            newsAnimationFinished = false;
            $('.news-item').addClass('shrink');

            $('.news-pagination__item').removeClass('news-pagination__item_active');
            $('.news-pagination__item').first().addClass('news-pagination__item_active');

            setTimeout(slideNewsPrev, 500);
        }

        function newsNext() {
            newsAnimationFinished = false;
            $('.news-item').addClass('shrink');

            $('.news-pagination__item').removeClass('news-pagination__item_active');
            $('.news-pagination__item').last().addClass('news-pagination__item_active');

            setTimeout(slideNewsNext, 500);
        }


        // триггеры

        $('.js-news-next').click(function(e) {
            if (newsAnimationFinished) {
                newsNext();
            }
        });

        $('.js-news-prev').click(function() {
            if (newsAnimationFinished) {
                newsPrev();
            }
        });













// 2. появления
// ==============

    // функция, которая "собирает" первый слайд. Запускается после прелоадера. См. прелоадер
    function lookMa() {
        $('.hero').removeClass('up');
        $('.swiper-slide').find('.hero__slide-number, .hero__info h1, .hero__info p, .hero__info a, .hero__img').removeClass('up');
    }

    // шторки
    $(window).scroll(function() {
        $('.trigger').each(function() {
            if( $(this).visible(true) ) {  
                $(this).find('.hideme').addClass('hideme_visible');
                $(this).find('.zero').removeClass('zero_hidden');
                $(this).find('.bg-square').removeClass('bg-square_anim');
            }        
        });
    });











// 3. меню
// ==============


    // 3.1 логика
    // -----------------

        function openMenu() {
            if ( !$('.menu').hasClass('menu_active') ) {
                $('.menu').addClass('menu_active');
                $('.menu .col-4').addClass('visible'); //анимации появления колонок
                $('body').addClass('no-scroll');
            } else {
                $('.menu').removeClass('menu_active');
                $('.menu .col-4').removeClass('visible');
                $('body').removeClass('no-scroll');
            }
        }

        $('.js-menu-controls').click(openMenu);


    // 3.2 Закрытие на esc
    // -----------------
        $(document).on( 'keydown', function ( e ) {
            if ( e.keyCode === 27 ) {
                if ( $('.menu').hasClass('menu_active') ) {
                 openMenu();
                }
            }
        });










// 4. форма
// ==============


    $('.js-floating-label').blur();

    $('.js-floating-label').on('focus', function() {
        $(this).parent().find('.signup-form__floating-placeholder').addClass('float');
    });

    $('.js-floating-label').on('blur', function() {
        if($(this).val()!=""){} else {
            $(this).parent().find('.signup-form__floating-placeholder').removeClass('float');
        };
    });










// 5. прелоадер
// ==============


    var width = 100,
        perfData = window.performance.timing, // The PerformanceTiming interface represents timing-related performance information for the given page.
        EstimatedTime = -(perfData.loadEventEnd - perfData.navigationStart),
        time = parseInt((EstimatedTime/1000)%60)*100;

    // Loadbar Animation
    $(".loadbar").animate({
      width: width + "%"
    }, time);


    // Percentage Increment Animation
    var PercentageID = $("#precent"),
            start = 0,
            end = 100,
            durataion = time;
            animateValue(PercentageID, start, end, durataion);
            
    function animateValue(id, start, end, duration) {
      
        var range = end - start,
          current = start,
          increment = end > start? 1 : -1,
          stepTime = Math.abs(Math.floor(duration / range)),
          obj = $(id);
        
        var timer = setInterval(function() {
            current += increment;
            $(obj).text(current + "%");
          //obj.innerHTML = current;
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    // Fading Out Loadbar on Finised
    setTimeout(function(){
      $('.overlay_loading').fadeOut(300);
      setTimeout(lookMa, 500);
    }, time);










// 6. параллакс
// ==============

    $.stellar();









// 7. прилипающий хедер
// ==============

    function showStickyHeader() {
        if ( window.pageYOffset > 0 ) {
           $('.page-header').addClass('page-header_sticky');
        }
        else {
            $('.page-header').removeClass('page-header_sticky');
        }
    };

    $(window).scroll(showStickyHeader); 




// 8. возможно, пригодится
// ==============

    /* МОДАЛЬНЫЕ ОКНА */
    $(document).ready(function(){   


        $(".js-open-modal").on('click', function(){
            console.log('click');
            var modalName = $(this).data('target');                        
            var modal = $('#' + modalName);
            if( !$(modal).hasClass('modal_active') ) {
                $(modal).addClass('modal_active');                          
            } else {
                $(modal).removeClass('modal_active');                          
            }
        });

        $(".js-close-modal").on('click', function(){
            $('.modal').removeClass('modal_active');
        });



        // $("#overlay, .modal .modal-close").on('click', function(){
        //     $(".overlay, .modal").fadeOut();
        // $('.modal').find('input, textarea').val('');
        //     return false;
        // });    


        // $('.modal').each(function(){
        //     var f=$(this).find('.modal-content');
        //     var t=$(this).find('.modal-content-copy');
        //     t.html(f.html());
        //     t.hide();

        // });
    });
    /* МОДАЛЬНЫЕ ОКНА END */


    // отправка колбека
    $(".modal form").on('submit', function(e){
            e.preventDefault();
            var modal = $(this).parents('.modal');
            var form = $(this);         
            $(this).ajaxSubmit({  
                url: "/ajax.php?file="+$(form).data('file'),
                data: $(form).serialize(),
                dataType: "JSON",
                type: "POST",
                success: function(data){
                    if(data.done) {
          $(modal).find('.modal-result').html(data.message);
          $(modal).find('.modal-result').show('fast')
          setTimeout("$('.modal-result').hide('fast')",1500);

          setTimeout("$('.modal').hide()",2000);
                      setTimeout("$('#overlay').hide()",2000);
          var f=$(modal).find('.modal-content-copy');
          var t=$(modal).find('.modal-content');
                      setTimeout("$('.modal').find('input, textarea').val('')",3000);
          
                    } else {
                        $(modal).find('.modal-errors').html(data.message);
        $(modal).find('.modal-errors').show('fast')
        setTimeout("$('.modal-errors').hide('fast')",1000);
                        $(modal).children(".spinner").hide();
                    }
                },
                complete: function(){
                    $(modal).children(".spinner").hide();                     
                }
            });
            return false;
        });



    function moveProgress() {
      var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
      var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      var scrolled = (winScroll / height) * 100;
      document.getElementById("progress").style.width = scrolled + "%";
    };




    function showToTopButton() {
        if ( window.pageYOffset > 500 ) {
           $('.to-top').addClass('to-top_visible')
        }
        else {
            $('.to-top').removeClass('to-top_visible')
        }
    }; 

    function scrollToTop() {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      return false;
    }; 
    $('.js-scroll-to-top').click(scrollToTop);
    $(window).scroll(showToTopButton);    



    $('.signup-form__masked-tel').mask('+7(999) 999-99-99');


});



  
   
 



// triggers
$(document).ready(function() {   
    // $('.js-menu-controls').click(openMenu);
    // $('.overlay_modal').click(openModal);

    // $(window).scroll(showStickyHeader);  
});



