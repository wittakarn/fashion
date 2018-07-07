var orderTemplate;
var $window = $(window);
var $orderPlaceholder;
var $scrollCheckPoing;
var fetcher;

function init(options) {
    $orderPlaceholder = $('#orderPlaceholder');
    $scrollCheckPoing = $('.scroll-check-point');
    fetcher = new Fetcher(options.order);
    fetcher.fetchPurchaseOrder({
        memberId: options.order.memberId,
        pos: 0,
        size: options.order.dataSize
    });
    orderTemplate = Handlebars.compile($('#orderTemplate').html());
}

function renderPurchaseOrder(payload, orders) {
    $scrollCheckPoing.addClass("invisible");
    if (orders && orders.length > 0) {
        if (payload.pos === 0) {
            $orderPlaceholder.html(orderTemplate(orders));
        } else {
            $orderPlaceholder.append(orderTemplate(orders));
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
        fetcher.fetchPurchaseOrder(payload);
        $window.off("scroll");
    }
}

var Fetcher = function (options) {
    this.order = options;
};

Fetcher.prototype.fetchPurchaseOrder = function (payload) {
    var ajaxParam = {
        url: this.order.url,
        data: payload,
        success: function (data, textStatus, xhr) {
            renderPurchaseOrder(payload, data);
        }
    };
    var ajax = new Ajax(ajaxParam);
    ajax.call();
}