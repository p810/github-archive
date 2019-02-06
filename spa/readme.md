# spa
> Another JavaScript single page application utility

## Usage
The compiled applet is available at `lib/app.js`. Include this file on your page(s) and initialize it with a CSS selector specifying the element
you wish to use as a container for views it fetches. Then, register event listeners to load that content however you prefer. In the example below
I'm binding an event listener to each `a` element, and using a data attribute in lieu of `href` for optimal SEO.

```javascript
const app = Application('div#container');

let links = document.querySelectorAll('a');
for (let link of links) {
    link.addEventListener('click', function (event) {
        if (this.dataset.hasOwnProperty('fetch')) {
            event.preventDefault();

            // The first option is the URL where the HTML we're requesting lives.
            // The second is the URL we want to mimic, which users should navigate to.
            // For example: <a href="/blog" data-fetch="/partials/blog.php"></a>
            app.request(this.dataset.fetch, this.href);
        }
    });
}
```

## Building
To make changes to the source, edit the files in `src/` and run `npm run compile` to build and minify it. You will need to install the dependencies
beforehand using NPM (`npm install`).

## Roadmap
- [ ] Implement two-way binding with elements like in Angular
- [ ] Better (more intelligent) response handler
- [ ] Events for things like requests, rendering
- [ ] Finish API documentation (add private methods)
