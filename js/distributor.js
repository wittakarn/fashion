var $window = $(window);
var productPlaceholder;
var productTemplate;
var fetcher;

function init(options) {
    productPlaceholder = $('#productPlaceholder');
    fetcher = new Fetcher(options.product);
    productTemplate = Handlebars.compile($('#productTemplate').html());
}

function renderAllProduct(cate3Id, cate3Name, lastPos, products) {
    var response = {
        cate3Id: cate3Id,
        productName: cate3Name,
        products: products,
    }
    productPlaceholder.append(productTemplate(response));
    $window.scroll(function () {
        loadMoreData(cate3Id, cate3Name, lastPos);
    });
}

function loadMoreData(cate3Id, cate3Name, lastPos) {

    var $scrollCheckPoint = $(".scroll-check-point").last();
    var topOfElement = $scrollCheckPoint.offset().top;
    var bottomOfElement = topOfElement + $scrollCheckPoint.outerHeight();
    var bottomOfScreen = $window.scrollTop() + window.innerHeight;
    var topOfScreen = $window.scrollTop();

    if ((bottomOfScreen > topOfElement) && (topOfScreen < bottomOfElement)) {
        fetcher.fetchProduct(cate3Id, cate3Name, lastPos);
        $window.off("scroll");
    }
}

var Fetcher = function (options) {
    this.product = options;
    emitter.on('brand_clicked', this.fetchProduct.bind(this));
};

Fetcher.prototype.fetchProduct = function (cate3Id, cate3Name, pos) {
    var payLoad = {
        cate3_id: cate3Id,
        pos: pos,
        size: 30
    };
    var ajaxParam = {
        url: this.product.url,
        data: payLoad,
        success: function (data, textStatus, xhr) {
            renderAllProduct(cate3Id, cate3Name, payLoad.pos + payLoad.size, data);
        }
    };
    var ajax = new Ajax(ajaxParam);
    ajax.call();
}