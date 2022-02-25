<?php
return [
    // no-numerals, no-capitalize, ambiguous, capitalize, num-passwords, numerals, remove-chars, secure, no-vowels, symbols, length
    [null, null, null, null, 1, null, null, null, null, null, 8192],
    [false, false, false, false, 1, true, null, false, false, null, 1],
    [true, true, true, true, 1, false, null, true, true, null, 1],
    [false, false, false, false, 1, false, 'ABCabc123~!"£$%^&*()\'/|\\><', false, false, false, 1],
    [false, true, false, false, 99, true, 'ABCabc123', true, false, true, 1],
    [true, false, true, true, 100, false, '$$££', false, true, false, 1],
    [true, false, true, true, 10, false, '-1', false, true, false, 1],
    [true, false, true, true, 5, false, '$', false, true, false, 1],
];
