<?php echo $header ?>


<main role="main" class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="/index.php" method="get">
                <input type="hidden" name="route" value="posts/posts"/>
                <div class="form-group">
                    <label for="formGroupExampleInput">Search</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search...">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Source</label>
                    <select class="form-control" name="source_id" id="source_id">
                        <option value="0">All</option>
                        <?php
                        foreach ($sources as $source) {
                            echo "<option value='" . $source["source_id"] . "'>" . $source["name"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Sort By</label>
                    <select class="form-control" name="sort" id="sort">
                        <option value="p.publish_time">Publish Time</option>
                        <option value="p.inserted_time">Crawler Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Order</label>
                    <select class="form-control" name="order" id="order">
                        <option value="ASC">ASC</option>
                        <option value="DESC">DESC</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
        </div>
        <div class="col-md-12 blog-main">
            <h3 class="pb-4 mb-4 font-italic border-bottom">
                News Crawler
            </h3>

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
