<!-- wp:group {"tagName":"main","className":"py-8 space-y-12"} -->
<main class="py-8 space-y-12">
  <!-- wp:query {"query":{"postType":"advert","metaKey":"advert_site","metaValue":"yes","orderBy":"menu_order","order":"asc"}} -->
  <!-- wp:post-template {"className":"grid grid-cols-2 gap-4"} -->
    <!-- wp:post-content /-->
  <!-- /wp:post-template -->
  <!-- /wp:query -->

  <!-- wp:shortcode -->[donate_box]<!-- /wp:shortcode -->

  <!-- wp:query {"query":{"postType":"presentation","perPage":1,"orderBy":"rand"}} -->
  <!-- wp:post-template -->
    <!-- wp:template-part {"slug":"slim-presentation"} /-->
  <!-- /wp:post-template -->
  <!-- /wp:query -->

  <!-- wp:query {"query":{"postType":"booth","perPage":1,"orderBy":"rand"}} -->
  <!-- wp:post-template -->
    <!-- wp:post-content /-->
  <!-- /wp:post-template -->
  <!-- /wp:query -->

  <!-- wp:query {"query":{"postType":"post","perPage":1}} -->
  <!-- wp:post-template -->
    <!-- wp:post-title {"level":2,"isLink":true,"className":"mb-2"} /-->
    <!-- wp:post-excerpt /-->
  <!-- /wp:post-template -->
  <!-- /wp:query -->

  <!-- wp:shortcode -->[about_newmr_box]<!-- /wp:shortcode -->
</main>
<!-- /wp:group -->
