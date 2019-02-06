var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
/**
 * Defines a class which implements the above interface.
 *
 * The constructor() method defines the phrase. Defaults to "Hello world" if one is not supplied.
 * output() will write the phrase to the command line.
 */
var HelloWorldConcrete = (function () {
    function HelloWorldConcrete(phrase) {
        if (phrase === void 0) { phrase = 'Hello world'; }
        this.phrase = phrase;
    }
    HelloWorldConcrete.prototype.output = function () {
        console.log(this.phrase);
    };
    return HelloWorldConcrete;
})();
/**
 * Extends the concrete class and tells the user to have a nice day
 */
var ExtendedHelloWorld = (function (_super) {
    __extends(ExtendedHelloWorld, _super);
    function ExtendedHelloWorld() {
        _super.apply(this, arguments);
    }
    ExtendedHelloWorld.prototype.output = function () {
        _super.prototype.output.call(this);
        console.log('Have a great day');
    };
    return ExtendedHelloWorld;
})(HelloWorldConcrete);
// ---- Tests ----
var list = [
    new HelloWorldConcrete(),
    new HelloWorldConcrete('Hello universe'),
    new ExtendedHelloWorld()
];
for (var index in list) {
    list[index].output();
}
