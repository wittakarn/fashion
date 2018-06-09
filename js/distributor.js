var productPlaceholder;
var productTemplate;

function init(options) {
    productPlaceholder = $('#productPlaceholder');
    new Fetcher(options.product);
    productTemplate = Handlebars.compile($('#productTemplate').html());
}

function renderAllProduct(cate3Id, cate3Name, products) {
    var response = {
        cate3Id: cate3Id,
        productName: cate3Name,
        products: products,
    }
//    alert(JSON.stringify(response));
    productPlaceholder.html(productTemplate(response));
}

var Fetcher = function (options) {
    this.product = options;
    emitter.on('brand_clicked', this.fetchProduct.bind(this));
};

Fetcher.prototype.fetchProduct = function (cate3Id, cate3Name) {
    var ajaxParam = {
        url: this.product.url,
        data: {
            cate3_id: cate3Id,
            pos: 0,
            size: 30
        },
        success: function (data, textStatus, xhr) {
            renderAllProduct(cate3Id, cate3Name, data);
        }
    };
    var ajax = new Ajax(ajaxParam);
    ajax.call();
}