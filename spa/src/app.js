const Application = (function (stage) {
    let _this = {};

    /**
     * @param {String} selector CSS selector for the element to use as a container.
     * @returns {undefined}
     */
    let setStage = function (selector) {
        _this.stage = document.querySelector(selector);
    };

    /**
     * @returns {HTMLElement}
     */
    let getStage = function () {
        if (_this.hasOwnProperty('stage') === false) {
            throw new ReferenceError('The application\'s container has not been set');
        }
        
        return _this.stage;
    };

    /**
     * @param {String} html The source to inject into the stage.
     * @returns {String}
     */
    let render = function (html) {
        return getStage().innerHTML = html;
    };

    /**
     * @param {String} requestUrl The URL to request.
     * @param {String} historyUrl A URL for the address bar.
     * @returns {undefined}
     */
    let request = function (requestUrl, historyUrl) {
        let request = new XMLHttpRequest();

        request.addEventListener('load', function () {
            if (historyUrl) {
                history.pushState({body: request.responseText}, '', historyUrl);
            }

            render(request.responseText);
        });

        request.open('GET', requestUrl);

        request.send();
    };

    setStage(stage);

    return {
        render: render,
        request: request
    };
});