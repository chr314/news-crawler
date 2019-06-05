<?php echo $header ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-12 blog-main" id="posts">

        </div>
        <button id="load-posts-btn" class="btn btn-primary col-md-12">Load More</button>
    </div>
</main>

<script id="posts-template" type="text/x-handlebars-template">
    {{#each this}}
    <div class="blog-post">
        <h2 class="blog-post-title">
            <a href="/index.php?route=posts/post&post_id={{post_id}}">{{title}}</a>
        </h2>
        <p class="blog-post-meta">{{datetime}}</p>
        <p>{{content}}</p>
        <hr>
    </div>
    {{/each}}
</script>

<?php echo $footer ?>
