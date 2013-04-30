<?php get_header() ?>
	<div id="container">
		<div id="content" role="main">
			<?php the_post() ?>
			<?php erdt_epigraph() ?>
			<div id="post-<?php the_ID() ?>" <?php post_class() ?>>
				<?php $quickLink = return_quickie_link(); ?>
				<h2 class="entry-title instapaper_title">
					<?php if(!empty($quickLink)): ?>
						<a title="<?php the_title() ?>" href="<?php echo $quickLink; ?>">
							<?php the_title() ?>
						</a>
					<?php else: ?>
						<a title="<?php the_title() ?>" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title() ?></a>
					<?php endif; ?>
				</h2>
				<div class="entry-content instapaper_body">
					<?php the_content() ?>
					<?php wp_link_pages('before=<div class="page-link instapaper_ignore">' . __( 'Pages:', 'erudite' ) . '&after=</div>') ?>
				</div>
				<div class="entry-meta">
					<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'erudite' ), the_date( '', '', '', false ), get_the_time() ) ?></abbr></span>
					<span class="meta-sep">|</span>
					<span class="author vcard"><?php printf( __( 'By %s', 'erudite' ), erdt_get_author_posts_link() ) ?></span>
					<span class="meta-sep">|</span>
					<span class="cat-links"><?php printf( __( 'Posted in %s', 'erudite' ), get_the_category_list(', ') ) ?></span>
					<span class="meta-sep">|</span>
					<?php the_tags( __( '<span class="tag-links">Tagged ', 'erudite' ), ", ", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
					<span class="meta-sep">|</span>
					<span class="meta-shortlink">Short Link <?php echo return_short_link(); ?></span>
					<?php edit_post_link( __( 'Edit', 'erudite' ), "\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Comments (0)', 'erudite' ), __( 'Comments (1)', 'erudite' ), __( 'Comments (%)', 'erudite' ) ) ?></span>
					<span class="meta-sep">|</span>
					<iframe border="0" scrolling="no" width="78" height="17" allowtransparency="true" frameborder="0" style="margin-bottom: -3px; z-index: 1338; border: 0px; background-color: transparent; overflow: hidden;" src="http://www.instapaper.com/e2?url=<?php echo urlencode(get_post_permalink()); ?>&title=<?php echo urlencode(the_title_attribute('echo=0')); ?>&description=<?php echo urlencode(get_the_excerpt()); ?>"></iframe>
				</div>
			</div><!-- .post -->

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ) ?></div>
				<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&rarr;</span>' ) ?></div>
			</div>

			<?php if(comments_status()): ?>
				<?php comments_template() ?>
			<?php else: ?>
				<div id="comments"></div>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>