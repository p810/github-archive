var Foo;
(function (Foo) {
    var Bar = (function () {
        function Bar() {
            console.log('Hello world');
        }
        return Bar;
    })();
    Foo.Bar = Bar;
})(Foo || (Foo = {}));
/// <reference path="module.ts" />
var Foo;
(function (Foo) {
    var HelloWorld = (function () {
        function HelloWorld() {
            console.log('Whatever');
        }
        return HelloWorld;
    })();
    Foo.HelloWorld = HelloWorld;
})(Foo || (Foo = {}));
/// <reference path="./module.ts" />
/// <reference path="./import.ts" />
new Foo.HelloWorld();
new Foo.Bar();
