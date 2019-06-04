<?php echo $header ?>


<main role="main" class="container">
    <div class="row">
        <div class="col-md-12 blog-main">
            <?php
            foreach ($posts as $post) {
                ?>
                <div class="blog-post">
                    <h2 class="blog-post-title"><a href="/index.php?route=posts/post&post_id=<?php echo $post["post_id"] ?>"><?php echo $post["title"] ?></a></h2>
                    <p class="blog-post-meta"><?php echo $post["publish_time"] ?></p>

                    <p><?php echo mb_substr(strip_tags($post["content"]),0, 500) ?>....</p>
                    <hr>

                </div>
            <?php } ?>

        </div>

    </div>

</main>

<?php echo $footer ?>
