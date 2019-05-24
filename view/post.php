<?php echo $header ?>


<main role="main" class="container">
    <div class="row">

        <div class="col-md-8 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                News Crawler
            </h3>

            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $post_data["title"] ?></h2>
                <p class="blog-post-meta"><?php echo $post_data["publish_time"] ?></p>

                <hr>
                <?php echo $post_data["content"] ?>
            </div>
        </div>

        <aside class="col-md-4 blog-sidebar">
            <div class="p-4 mb-3 bg-light rounded">
                <h4 class="font-italic">About the Source</h4>
                <p class="mb-0"><?php echo $post_data["name"] ?></p>
                <a href="<?php echo $post_data["source_url"] ?>" target="_blank"><p class="mb-0">Original Post</p></a>
            </div>

            <div class="p-4 mb-3 bg-light rounded">
                <h4 class="font-italic">About the Author</h4>
                <p class="mb-0"></p>
                <a href=""><p class="mb-0"></p></a>
            </div>
        </aside>

    </div>

</main>

<?php echo $footer ?>
