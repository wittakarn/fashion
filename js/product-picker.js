var $researveProductPlaceholder;
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
        summary += Number(product.productPrice);
    });
    products.summary = summary.formatMoney(2, '.', ',');
    $researveProductPlaceholder.html(researveProductTemplate(products));
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