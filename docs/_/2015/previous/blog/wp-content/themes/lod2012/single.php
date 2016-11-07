<?php get_header(); ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="content" class="group">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p class="comments"><a href="<?php comments_link(); ?>"><?php comments_number('without comments','with one comment','with % comments'); ?></a></p>

<div class="social">

<a href="https://twitter.com/share" class="twitter-share-button" data-via="LodJapan" data-lang="ja" data-hashtags="lod2012">ツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<div class="fb-like" data-send="false" data-layout="button_count" data-width="80" data-show-faces="true"></div>
</div>

<div class="main">
	<?php the_content('Read the rest of this entry &raquo;'); ?>
</div>

<div class="meta group clear">
<div class="signature">
    <p>Written by <?php the_author() ?> <span class="edit"><?php edit_post_link('Edit'); ?></span></p>
    <p><?php the_time('F jS, Y'); ?> <?php _e("at"); ?> <?php the_time('g:i a'); ?></p>
</div>	
<div class="tags">
    <p>Posted in <?php the_category(',') ?></p>
    <?php if ( the_tags('<p>Tagged with ', ', ', '</p>') ) ?>
</div>
</div>

<div class="navigation group">
    <div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
    <div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
</div>

<?php if ( comments_open() ) comments_template(); ?>

<?php endwhile; else: ?>
<div class="warning">
	<p>Sorry, but you are looking for something that isn't here.</p>
</div>
<?php endif; ?>

</div> 

<?php get_sidebar(); ?>

<?php get_footer(); ?>
