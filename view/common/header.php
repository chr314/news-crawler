<!doctype html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140693089-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-140693089-1');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ page.description | default: site.description | smartify }}">
    <meta name="author" content="{{ site.authors }}">

    <title>
        <?php echo $title ?>
    </title>

    <link rel="canonical" href="<?php echo $canonical ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">

    <?php
    if (!empty($scripts) && is_array($scripts)) {
        foreach ($scripts as $script) {
            echo '<script src="' . $script . '"></script>';
        }
    }

    if (!empty($styles) && is_array($styles)) {
        foreach ($styles as $style) {
            echo '<link href="' . $style . '" rel="stylesheet" type="text/css">';
        }
    }
    ?>
</head>
<body>


<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="text-muted" target="_blank" href="https://github.com/chr314/news-crawler">Github</a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="/"><?php echo $site_name ?></a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="text-muted" href="#searchCollapse" data-toggle="collapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img"
                         viewBox="0 0 24 24" focusable="false"><title>Search</title>
                        <circle cx="10.5" cy="10.5" r="7.5"/>
                        <path d="M21 21l-5.2-5.2"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <?php foreach ($sources as $source) {
                echo '<a class="p-2 text-muted" href="/index.php?route=posts/posts&source_id=' . $source["source_id"] . '">' . $source["name"] . '</a>';
            } ?>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-12 collapse" id="searchCollapse">
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
    </div>
</div>
