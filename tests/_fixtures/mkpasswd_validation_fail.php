<?php
return [
    // input, method, rounds, salt
    [null, null, null, null],
    [null, 'md5crypt', null, null],
    ['abcdefg', 'badmethod', 5000, 'abcdefgh'], // Invalid method
    ['abcdefg', 'md5crypt', 50000000, 'abcdefgh'], // Rounds too long
    ['-$1-abc', 'md5crypt', 50000000, 'abcdefgh'], // Bad name
    ['$1', 'md5crypt', 50000000, 'abcdefgh'], // Bad name

    // sha512crypt
    [null, 'sha512crypt', 5000, "1"],
    ['abcdefg', 'sha512crypt', 5000, "a"], // Salt too short
    ['abcdefg', 'sha512crypt', 5000, "abcdefghijklmnopqrstuvw"], // Salt too long

    // md5crypt
    [null, 'md5crypt', 5000, "1"],
    ['abcdefg', 'md5crypt', 5000, "1"], // Salt too short
    ['abcdefg', 'md5crypt', 5000, "1234567890"], // Salt too long

    // scrypt
    ['abcdefg', 'scrypt', 5000, "abcdefgh"], // Doesn't accept salt
];
