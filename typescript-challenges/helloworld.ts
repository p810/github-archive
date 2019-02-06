/**
 * Defines a contract for an object where a string "phrase" must be supplied and a boolean "compliment" may be
 */
interface Example {
  phrase: string;
  compliment?: boolean;
}


/**
 * Outputs the supplied phrase and optionally compliments the user.
 */
function test(some_object: Example) {
  console.log(some_object.phrase);
  
  if(some_object.compliment) {
    console.log('You look great today!');
  }
}


// ---- Test ----

test({
  phrase: 'Hello world!'
});

test({
  phrase: 'Hello world!',
  compliment: true
});

test({
  phrase: 'Hello world!',
  compliment: false
});