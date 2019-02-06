/**
 * Defines an abstract class with a private and static property.
 * 
 * An accessor is also defined to return the private property in child classes and instantiated objects.
 */
class Abstract {
  private _verb: string;
  static greeting = 'Hello';
  
  constructor(who: string) {
    this._verb = who;
  }
  
  get phrase() : string {
    return this._verb;
  }
}


/**
 * Defines output() which will combine the static property greeting with the private property _verb.
 */
class Concrete extends Abstract {
  constructor() {
    super("world!");
  }
  
  output() {
    console.log(Concrete.greeting + ' ' + this.phrase);
  }
}


// ---- Tests ----

var object = new Concrete;

object.output();