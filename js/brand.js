var $brands = $('.brand__link');

var emitter = new EventEmitter();

function initBrandsEvent(){
    $brands.click(emitClickEvent);
}

function emitClickEvent(){
    $this = $(this);
    var params = {
        cate3Id: $this.attr('cate3-id'),
        cate3Name: $this.attr('cate3-name'),
        cate3Opt: $this.attr('cate3-opt'),
        pos: 0,
        size: 30
    }
    emitter.emit('brand_clicked', params);
}

initBrandsEvent();