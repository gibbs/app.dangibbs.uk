<?php
return [
    // no-numerals, no-capitalize, ambiguous, capitalize, num-passwords, numerals, remove-chars, secure, no-vowels, symbols, length
    [null, null, null, null, null, null, null, null, null, null, null],

    // Too many passwords
    [null, null, null, null, 20000, null, null, null, null, null, null],

    // No chars specified
    [null, null, null, null, 1, null, null, null, null, 4, 1],

    // Length too long
    [null, null, null, null, 1, null, null, null, null, 4, 8193],
];
