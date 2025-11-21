(function(){
  function initCarousels(root){
    var containers = (root || document).querySelectorAll('.cfce-carousel');
    containers.forEach(function(el){
      // Avoid double init
      if (el.__cfceSwiper) {
        try { el.__cfceSwiper.update(); } catch(e) {}
        return;
      }

      var autoplay = el.dataset.autoplay === 'true'
        ? { delay: parseInt(el.dataset.delay || '5000', 10), disableOnInteraction: false }
        : false;

      var pagination = el.dataset.pagination === 'true'
        ? { el: el.querySelector('.cfce-carousel__pagination'), clickable: true }
        : undefined;

      var navigation = el.dataset.navigation === 'true'
        ? {
            nextEl: el.querySelector('.cfce-carousel__next'),
            prevEl: el.querySelector('.cfce-carousel__prev')
          }
        : undefined;

      var slidesCount = el.querySelectorAll('.cfce-carousel__slide').length;
      var shouldLoop = (el.dataset.loop === 'true') && slidesCount > 1;

      var swiper = new Swiper(el, {
        wrapperClass: 'cfce-carousel__track',
        slideClass: 'cfce-carousel__slide',
        slidesPerView: 1,
        spaceBetween: 0,
        loop: shouldLoop,
        observeParents: true,
        observer: true,
        watchOverflow: true,
        autoplay: autoplay,
        pagination: pagination,
        navigation: navigation,
      });

      el.__cfceSwiper = swiper;

      // Ensure updates on resize for correct widths, especially on mobile
      if (typeof ResizeObserver !== 'undefined') {
        try {
          var ro = new ResizeObserver(function(){
            if (el.__cfceSwiper) {
              try { el.__cfceSwiper.update(); } catch(e) {}
            }
          });
          ro.observe(el);
          el.__cfceSwiperResizeObserver = ro;
        } catch(e) {}
      } else {
        window.addEventListener('resize', function(){
          if (el.__cfceSwiper) {
            try { el.__cfceSwiper.update(); } catch(e) {}
          }
        });
      }
    });
  }

  // Frontend
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function(){ initCarousels(document); });
  } else {
    initCarousels(document);
  }

  // Handle Gutenberg editor dynamic updates
  if (window.wp && wp.domReady) {
    wp.domReady(function(){
      // Initial
      initCarousels(document);
      // Listen for block updates; simple MutationObserver to catch re-renders in editor iframe
      var observer = new MutationObserver(function(){
        initCarousels(document);
      });
      observer.observe(document.body, { childList: true, subtree: true });
    });
  }
})();
