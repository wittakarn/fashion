var $brands = $('.brand__link');

var emitter = new EventEmitter();

function initBrandsEvent(){
    $brands.click(emitClickEvent);
}

function emitClickEvent(){
    $this = $(this);
    emitter.emit('brand_clicked', $this.attr('cate3-id'), $this.attr('cate3-name'));
}

initBrandsEvent();