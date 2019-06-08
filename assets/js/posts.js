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

var posts_page = 1;
var posts_filters = "";

$("#searchCollapse > form").submit(false);

let url_params = new URLSearchParams(window.location.search);
let available_params = ["sort", "order", "source_id", "search"];

let params = {};
for (let param of available_params) {
    if (url_params.has(param)) {
        params[param] = url_params.get(param);
    }
}
let params_query = Object.keys(params)
    .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
    .join('&');

load_tpl("/index.php?route=posts/posts_json&page=" + posts_page + "&" + params_query, "#posts-template", "#posts");

$("#searchCollapse button[type='submit']").on("click", function () {
    posts_page = 1;
    posts_filters = $("#searchCollapse > form").serialize();
    let url = "/index.php?route=posts/posts_json&page=" + posts_page + "&" + posts_filters;
    load_tpl(url, "#posts-template", "#posts");
});

$("#load-posts-btn").on("click", function () {
    posts_page++;
    let url = "/index.php?route=posts/posts_json&page=" + posts_page + "&" + posts_filters;
    load_tpl(url, "#posts-template", "#posts", true);
});
