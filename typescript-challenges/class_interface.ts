interface HelloWorldInterface {
  phrase: string;
  output(): void;
}


/**
 * Defines a class which implements the above interface.
 * 
 * The constructor() method defines the phrase. Defaults to "Hello world" if one is not supplied.
 * output() will write the phrase to the command line.
 */
class HelloWorldConcrete implements HelloWorldInterface {
  phrase: string;
  
  constructor(phrase: string = 'Hello world') {
    this.phrase = phrase;
  }
  
  output() {
    console.log(this.phrase);
  }
}


/**
 * Extends the concrete class and tells the user to have a nice day
 */
class ExtendedHelloWorld extends HelloWorldConcrete {
  output() {
    super.output();
    
    console.log('Have a great day');
  }
}


// ---- Tests ----

var list = [
  new HelloWorldConcrete(),
  new HelloWorldConcrete('Hello universe'),
  new ExtendedHelloWorld()
];

for(var index in list) {
  list[index].output();
}