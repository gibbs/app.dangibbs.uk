<?php
return [
    // input, method, rounds, salt
    ['testabc', 'md5crypt', 5000, 'salty123'],
    //['--abc--', 'md5crypt', 25000, '-alty12-'],
    //['-?abc-{}', 'md5crypt', 25000, '|alty1_-'],
    ['testabc', 'scrypt', null, null],
    ['testabc', 'sha256crypt', 50000, 'abcdefgh12345678'],
    //['&#;`|*?~<>^()[]{}$\\', 'sha256crypt', 50000, '&#;`|*?~<>^()[]{}$\\'],
    ['a', 'sha256crypt', 100000, 'abcdefgh'],
    ['testabc', 'sha512crypt', 5000, 'abcdefgh'],
    ['2', 'sha512crypt', 5000, 'abcdefgh12345678'],
];
