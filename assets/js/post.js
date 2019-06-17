function load_tpl(url, tpl, target, append = false) {
    $.getJSON(url, function (data) {
        if (data.status === "success") {
            let template = $(tpl).html();
            let stone = Handlebars.compile(template)(data.data);
            if (!append) {
                $(target).html(stone);
            } else {
                $(target).append(stone);
            }
        }
    });
}

load_tpl("/index.php?route=posts/posts_json&page=1&per_page=10", "#recommended-posts-template", "#recommended-posts", true);