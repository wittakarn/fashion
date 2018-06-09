function Ajax(ajaxParam) {

    this.url = ajaxParam.url;
    this.type = ajaxParam.type;
    this.requestData = ajaxParam.data;
    this.successCallback = ajaxParam.success;
    this.errorCallback = ajaxParam.error;

    this.call = function (response) {
        $.ajax({
            url: this.url,
            type: this.type ? this.type : "get",
            contentType: "application/json",
            dataType: "json",
            cache: false,
            data: this.requestData,
            success: this.successCallback,
            error: this.errorCallback ?
                    this.errorCallback :
                    function (jqXHR, textStatus, errorThrown) {
                        alert("Error, status = " + textStatus + ", " +
                                "error thrown: " + errorThrown
                                );
                    }
        });
    };
}