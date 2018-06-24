var $window = $(window);
var paddingVerticalClassName = 'padding-vertical';
var reserveProductButtonSelector = '.reserve-button';
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
    if(options.extraParam) {
        fetcher.fetchProduct(options.extraParam);
    }
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
        $productOptionPlaceholder.removeClass(paddingVerticalClassName);
        $productPlaceholder.removeClass(paddingVerticalClassName)
        if (payload.pos === 0) {
            $productOptionPlaceholder.empty();
            $productPlaceholder.empty();
            placeholder.html(template(response));
            placeholder.addClass(paddingVerticalClassName);
        } else {
            placeholder.append(template(response));
        }
        
        $(reserveProductButtonSelector).off('click');
        $(reserveProductButtonSelector).click(function () {
            var $this = $(this);
            var productUid = $this.attr('product-uid');
            var imageSrc = $this.attr('image-src');
            var productDetail = $this.attr('product-detail');
            var productPrice = $this.attr('product-price');
            putReserveProductToLocalStorage(productUid, imageSrc, productDetail, productPrice);
        });

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

function putReserveProductToLocalStorage(productUid, imageSrc, productDetail, productPrice) {
    var isDuplicateProductUid = false;
    if (localStorage.products) {
        var products = JSON.parse(localStorage.products);
        $.map(products, function (product) {
            if (product.productUid === productUid) {
                isDuplicateProductUid = true;
                return;
            }
        });
        if (!isDuplicateProductUid) {
            products.push({
                productUid: productUid,
                imageSrc: imageSrc,
                productDetail: productDetail,
                quantity: 1,
                productPrice: productPrice,
                productTotalPrice: productPrice
            });
        }
        localStorage.products = JSON.stringify(products);
        emitter.emit('reserve_clicked', products.length);
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