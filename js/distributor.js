var $window = $(window);
var $productOptionPlaceholder;
var $productPlaceholder;
var $productOptionTemplate;
var $productTemplate;
var $scrollCheckPoing;
var fetcher;

function init(options) {
    $productPlaceholder = $('#productPlaceholder');
    $productOptionPlaceholder = $('#productOptionPlaceholder');
    $scrollCheckPoing = $(".scroll-check-point");
    fetcher = new Fetcher(options.product);
    productOptionTemplate = Handlebars.compile($('#productOptionTemplate').html());
    productTemplate = Handlebars.compile($('#productTemplate').html());
}

function renderAllProduct(payload, products) {
    $scrollCheckPoing.addClass("invisible");
    if (products && products.length > 0) {
        var response = {
            cate3Id: payload.cate3Id,
            productName: payload.cate3Name,
            products: products,
        }
        var hasOption = payload.cate3Opt === "y";
        var template = hasOption ? productOptionTemplate : productTemplate;
        var placeholder = hasOption ? $productOptionPlaceholder : $productPlaceholder;
        if (payload.pos === 0) {
            $productOptionPlaceholder.empty();
            $productPlaceholder.empty();
            placeholder.html(template(response));
        } else {
            placeholder.append(template(response));
        }

        payload.pos = payload.pos + payload.size;
        $window.off("scroll");
        if ($(document).height() > $window.height()) {
            $window.scroll(function () {
                loadMoreData(payload);
            });
        } else {
            // try to load more data when page did not have enough data to show browser scroll bar.
            loadMoreData(payload);
        }
    }
}

function loadMoreData(payload) {
    var topOfElement = $scrollCheckPoing.offset().top;
    var bottomOfElement = topOfElement + $scrollCheckPoing.outerHeight();
    var bottomOfScreen = $window.scrollTop() + window.innerHeight;
    var topOfScreen = $window.scrollTop();

    if ((bottomOfScreen > topOfElement) && (topOfScreen < bottomOfElement)) {
        $scrollCheckPoing.removeClass("invisible");
        fetcher.fetchProduct(payload);
        $window.off("scroll");
    }
}

var Fetcher = function (options) {
    this.product = options;
    emitter.on('brand_clicked', this.fetchProduct.bind(this));
};

Fetcher.prototype.fetchProduct = function (payload) {
    var ajaxParam = {
        url: this.product.url,
        data: payload,
        success: function (data, textStatus, xhr) {
            renderAllProduct(payload, data);
        }
    };
    var ajax = new Ajax(ajaxParam);
    ajax.call();
}