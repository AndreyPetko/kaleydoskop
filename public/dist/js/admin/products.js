$(document).ready(function () {
    var parts = window.location.search.substr(1).split("&");
    var $_GET = {};
    for (var i = 0; i < parts.length; i++) {
        var temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }


    var links = $('.pagination li a').each(function () {
        var newHref;
        var href = $(this).attr('href');
        var str = href.substring(href.indexOf('?'));
        var parts = str.substr(1).split("&");
        var temp = parts[0].split("=");
        var page = temp[1];

        if ($_GET['brendId'] === undefined) {
            newHref = "http://www.kaleydoskop-vishivki.com.ua/admin/products?page=" + page;
        } else {
            newHref = "http://www.kaleydoskop-vishivki.com.ua/admin/products?brendId=" + $_GET['brendId'] + "&categoryId=" + $_GET['categoryId']
                + "&group=" + $_GET['group'] + "&search=" + $_GET['search'] + "&page=" + page;
        }

        $(this).attr('href', newHref);
    });


    $('.delete-product-form').submit(function (e) {
        e.preventDefault();

        var currentItem = $(this);
        var $inputs = currentItem.find(':input');
        var data = {};

        $inputs.each(function () {
            data[this.name] = $(this).val();
        });

        $.ajax({
            url: '/admin/product-delete',
            method: 'POST',
            data: data,
            success: function() {
                currentItem.parent().parent().hide();
            }
        });
    });

});