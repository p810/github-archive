This is an experimentation with delta compression. I'm trying to wrap my head around the idea and come up with some practical implementations of it.

## API
#### `<array> Delta::encode(<array> $values)`
Returns a delta based on a list of values supplied.

For example, consider the string `Hello world`. Using the ASCII value of each character in the string its delta would be `72 29 7 0 3 -79 87 -8 3 -6 -8`.

#### `<array> Delta::decode(<array> $delta)`
Returns the original values from a delta.

#### `<array> Delta::diff(<array> $x, <array> $y)`
Returns the difference of two deltas.

Note that `$x` is the original delta and `$y` is the changed version.
