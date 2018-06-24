var $brands = $('.brand__link');
var $productReservedCount = $('#productReservedCount');

var emitter = new EventEmitter();

function initBrandsEvent() {
    if (!localStorage.products) {
        localStorage.products = "[]";
    }
    $brands.click(emitClickEvent);
    emitter.on('reserve_clicked', updateReserveCount);
    updateReserveCount(JSON.parse(localStorage.products).length);
}

function emitClickEvent() {
    $this = $(this);
    var params = {
        priceType: priceType,
        cate3Id: $this.attr('cate3-id'),
        cate3Name: $this.attr('cate3-name'),
        cate3Opt: $this.attr('cate3-opt'),
        pos: 0,
        size: 30
    };
    emitter.emit('brand_clicked', params);
}

function updateReserveCount(productCount) {
    $productReservedCount.html(productCount);
}

initBrandsEvent();