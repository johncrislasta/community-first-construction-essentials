(function(){
  function initCarousels(root){
    var containers = (root || document).querySelectorAll('.cfce-carousel');
    containers.forEach(function(el){
      // Avoid double init
      if (el.__cfceSwiper) return;

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

      var swiper = new Swiper(el, {
        wrapperClass: 'cfce-carousel__track',
        slideClass: 'cfce-carousel__slide',
        slidesPerView: 1,
        spaceBetween: 0,
        loop: el.dataset.loop === 'true',
        autoplay: autoplay,
        pagination: pagination,
        navigation: navigation,
      });

      el.__cfceSwiper = swiper;
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
      var observer = new MutationObserver(function(){ initCarousels(document); });
      observer.observe(document.body, { childList: true, subtree: true });
    });
  }
})();
