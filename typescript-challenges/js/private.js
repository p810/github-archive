var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
};
/**
 * Defines an abstract class with a private and static property.
 *
 * An accessor is also defined to return the private property in child classes and instantiated objects.
 */
var Abstract = (function () {
    function Abstract(who) {
        this._verb = who;
    }
    Object.defineProperty(Abstract.prototype, "phrase", {
        get: function () {
            return this._verb;
        },
        enumerable: true,
        configurable: true
    });
    Abstract.greeting = 'Hello';
    return Abstract;
})();
/**
 * Defines output() which will combine the static property greeting with the private property _verb.
 */
var Concrete = (function (_super) {
    __extends(Concrete, _super);
    function Concrete() {
        _super.call(this, "world!");
    }
    Concrete.prototype.output = function () {
        console.log(Concrete.greeting + ' ' + this.phrase);
    };
    return Concrete;
})(Abstract);
// ---- Tests ----
var object = new Concrete;
object.output();
