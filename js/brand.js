var $brands = $('.brand__link');
var $productReservedCount = $('#productReservedCount');

var emitter = new EventEmitter();

function initBrandsEvent(){
    $brands.click(emitClickEvent);
    emitter.on('reserve_clicked', updateReserveCount);
}

function emitClickEvent(){
    $this = $(this);
    var params = {
        priceType: priceType,
        cate3Id: $this.attr('cate3-id'),
        cate3Name: $this.attr('cate3-name'),
        cate3Opt: $this.attr('cate3-opt'),
        pos: 0,
        size: 30
    }
    emitter.emit('brand_clicked', params);
}

function updateReserveCount(productCount){
    $productReservedCount.html(productCount);
}

initBrandsEvent();