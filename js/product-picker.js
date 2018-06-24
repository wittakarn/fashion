var $researveProductPlaceholder;
var $summaryPriceDisplay;
var $summaryPriceInputHidden;
var researveProductTemplate;

function init(options) {
    $researveProductPlaceholder = $('#researveProductPlaceholder');
    researveProductTemplate = Handlebars.compile($('#researveProductTemplate').html());
    displayAllReserveProduct();
    emitter.on('brand_clicked', function (param) {
        redirectToDistributorPage(param, options.redirectUrl);
    });
}

function redirectToDistributorPage(param, url) {
    var redirectUrl = url.concat("?priceType=").concat(param.priceType).concat("&extraParam=").concat(JSON.stringify(param));
    redirect(redirectUrl);
}

function displayAllReserveProduct() {
    var products = JSON.parse(localStorage.products);
    var summary = 0;
    products.forEach(function (product) {
        summary += Number(product.productPrice) * Number(product.quantity);
    });
    products.summary = summary.formatMoney(2, '.', ',');
    $researveProductPlaceholder.html(researveProductTemplate(products));
    $summaryPriceDisplay = $('#summaryPriceDisplay');
    $summaryPriceInputHidden = $('#summaryPriceInputHidden');
    bindEvent();
}

function bindEvent() {
    var $quantityIconPlus = $('.quantity__icon--plus');
    var $quantityIconMinus = $('.quantity__icon--minus');
    var $quantityInputs = $('.quantity');
    var $removeButton = $('.remove-button');

    $quantityIconPlus.click(increaseQuantity);
    $quantityIconMinus.click(decreaseQuantity);
    $quantityInputs.change(updateReserveProduct);
    $removeButton.click(removeReserveProduct);
}

function decreaseQuantity() {
    var $ul = $(this).parent().parent();
    var $quantityInput = $ul.find('.quantity');
    var quantity = Number($quantityInput.val());
    if (quantity > 1) {
        quantity = Number($quantityInput.val()) - 1;

        $quantityInput.val(quantity);

        updateTotalPrice($ul, quantity);
        var $productUid = $ul.find("input[name='productUid[]']");
        updateLocalStorageQuantity($productUid.val(), quantity);
    }
}

function increaseQuantity() {
    var $ul = $(this).parent().parent();
    var $quantityInput = $ul.find('.quantity');
    var quantity = Number($quantityInput.val()) + 1;

    $quantityInput.val(quantity);

    updateTotalPrice($ul, quantity);
    var $productUid = $ul.find("input[name='productUid[]']");
    updateLocalStorageQuantity($productUid.val(), quantity);
}

function updateReserveProduct() {
    var $this = $(this);
    var $ul = $this.parent().parent();
    var quantity = Number($this.val());

    updateTotalPrice($ul, quantity);

    var $productUid = $ul.find("input[name='productUid[]']");
    updateLocalStorageQuantity($productUid, quantity);
}

function removeReserveProduct() {
    var $ul = $(this).parent().parent();
    var productUid = $ul.find("input[name='productUid[]']").val();
    var products = JSON.parse(localStorage.products);
    products.forEach(function (product, index, object) {
        if (product.productUid === productUid) {
            object.splice(index, 1);
            return;
        }
    });
    $ul.remove();
    updateProductLocalStorageSummary(products);
    emitter.emit('reserve_clicked', products.length);
}

function updateTotalPrice($ul, quantity) {
    var $productPrice = $ul.find("input[name='productPrice[]']");
    var $productTotalPrice = $ul.find("input[name='productTotalPrice[]']");
    var $totalPrice = $ul.find('.researve-product__detail--total-price');
    var totalPrice = Number($productPrice.val()) * quantity;
    $productTotalPrice.val(totalPrice);
    $totalPrice.html(totalPrice.formatMoney(2, '.', ','));
}

function updateLocalStorageQuantity(productUid, quantity) {
    var products = JSON.parse(localStorage.products);
    products.forEach(function (product) {
        if (product.productUid === productUid) {
            product.quantity = quantity;
            product.productTotalPrice = product.productPrice * quantity;
            return;
        }
    });
    localStorage.products = JSON.stringify(products);
    updateProductLocalStorageSummary();
}

function updateProductLocalStorageSummary(products) {
    if (!products) {
        products = JSON.parse(localStorage.products);
    }
    var summary = 0;
    products.forEach(function (product) {
        summary += Number(product.productPrice) * Number(product.quantity);
    });
    products.summary = summary.formatMoney(2, '.', ',');
    $summaryPriceDisplay.html(products.summary);
    $summaryPriceInputHidden.val(products.summary);
    localStorage.products = JSON.stringify(products);
}

Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}