var quotationDetailTemplate;
var quotationMastTemplate;
var $window = $(window);
var $quotationDetailPlaceholder;
var $quotationMastPlaceholder;
var $quotationInput;
var $fetchDataButton;
var fetcher;

function init(options) {
    $quotationMastPlaceholder = $('#quotationMastPlaceholder');
    $quotationDetailPlaceholder = $('#quotationDetailPlaceholder');
    $quotationInput = $('#quotationInput');
    $fetchDataButton = $('#fetchDataButton');
    fetcher = new Fetcher(options.quotation);
    quotationDetailTemplate = Handlebars.compile($('#quotationDetailTemplate').html());
    quotationMastTemplate = Handlebars.compile($('#quotationMastTemplate').html());
    
    $fetchDataButton.click(fetchQuotation);
}

function fetchQuotation(){
    fetcher.fetchQuotation({
        quot_no: $quotationInput.val()
    });
}

function renderQuotation(data, textStatus, xhr) {
    $quotationDetailPlaceholder.html(quotationDetailTemplate(data.quotDetail));
    $quotationMastPlaceholder.html(quotationMastTemplate(data.quotMast));
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
    this.quotation = options;
};

Fetcher.prototype.fetchQuotation = function (payload) {
    var ajaxParam = {
        url: this.quotation.url,
        data: payload,
        success: renderQuotation
    };
    var ajax = new Ajax(ajaxParam);
    ajax.call();
}