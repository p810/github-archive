/**
 * Takes a variadic list of people to say hello to. Uses the splat operator like in other languages.
 *
 * A typehint is still possible, but shorthand array syntax denotes that its items should be of that type.
 */
function say_hello() {
    var people = [];
    for (var _i = 0; _i < arguments.length; _i++) {
        people[_i - 0] = arguments[_i];
    }
    if (!people) {
        console.log('There\'s no one here!');
    }
    else {
        var total = people.length;
        var names = '';
        for (var i = 0; i < total; i++) {
            names += people[i];
            if (i < (total - 1)) {
                names += ', ';
            }
        }
        console.log('Hello ' + names);
    }
}
say_hello('John', 'George');
say_hello('John');
