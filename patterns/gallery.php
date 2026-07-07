<?php
/**
 * Title: Gallery
 * Slug: rozholy/gallery
 * Categories: rozholy, gallery
 * Description: Salon gallery with staggered image reveal
 */
?>
<!-- wp:group {"layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"clamp(4rem, 10vh, 9rem)","bottom":"clamp(4rem, 10vh, 9rem)"}}}} -->
<div class="wp-block-group" style="padding-top:clamp(4rem, 10vh, 9rem);padding-bottom:clamp(4rem, 10vh, 9rem)">
  <!-- wp:group {"layout":{"type":"constrained","contentSize":"600px"},"style":{"spacing":{"margin":{"bottom":"50px"}}}} -->
  <div class="wp-block-group" style="margin-bottom:50px" data-reveal="fade-up">
    <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"clamp(2rem, 5vw, 2.5rem)"}}} -->
    <h2 class="wp-block-heading has-text-align-center" style="font-size:clamp(2rem, 5vw, 2.5rem)"><span class="text-gradient">گالری تصاویر</span></h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","textColor":"text-light","style":{"typography":{"fontSize":"1.1rem"}}} -->
    <p class="has-text-align-center has-text-light-color has-text-color" style="font-size:1.1rem">نمونه کارهای ما را تماشا کنید</p>
    <!-- /wp:paragraph -->
  </div>
  <!-- /wp:group -->

  <!-- wp:gallery {"columns":3,"imageCrop":true,"linkTo":"none","style":{"spacing":{"blockGap":"16px"}}} -->
  <figure class="wp-block-gallery has-nested-images columns-3 is-cropped">
    <!-- wp:image {"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large" data-reveal="fade-scale" data-reveal-delay="1"><img src="https://placehold.co/600x600/d4a0a0/ffffff?text=Salon+1" alt="گالری سالن" style="border-radius:12px"/></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large" data-reveal="fade-scale" data-reveal-delay="2"><img src="https://placehold.co/600x600/b8a0c0/ffffff?text=Salon+2" alt="گالری سالن" style="border-radius:12px"/></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large" data-reveal="fade-scale" data-reveal-delay="3"><img src="https://placehold.co/600x600/c8a87c/ffffff?text=Salon+3" alt="گالری سالن" style="border-radius:12px"/></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large" data-reveal="fade-scale" data-reveal-delay="1"><img src="https://placehold.co/600x600/d4a0a0/ffffff?text=Salon+4" alt="گالری سالن" style="border-radius:12px"/></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large" data-reveal="fade-scale" data-reveal-delay="2"><img src="https://placehold.co/600x600/f0d0d0/333333?text=Salon+5" alt="گالری سالن" style="border-radius:12px"/></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large" data-reveal="fade-scale" data-reveal-delay="3"><img src="https://placehold.co/600x600/9870a8/ffffff?text=Salon+6" alt="گالری سالن" style="border-radius:12px"/></figure>
    <!-- /wp:image -->
  </figure>
  <!-- /wp:gallery -->
</div>
<!-- /wp:group -->
