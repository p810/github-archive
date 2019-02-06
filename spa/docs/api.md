## Public
These methods may be used by the application instance or internally.

### Application.request({String} requestUrl [, {?String} historyUrl])
Make an AJAX request for the given `requestUrl` and injects the HTML it receives into the application's container.

Optionally `historyUrl` may be passed. This value will replace the URL in the browser's address bar.

### Application.render({String} html)
Updates the container's `innerHTML` property with the supplied `html`.

## Private
These methods are not returned by the application instance and are for use within the object.
