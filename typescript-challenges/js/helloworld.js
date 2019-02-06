/**
 * Outputs the supplied phrase and optionally compliments the user.
 */
function test(some_object) {
    console.log(some_object.phrase);
    if (some_object.compliment) {
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
