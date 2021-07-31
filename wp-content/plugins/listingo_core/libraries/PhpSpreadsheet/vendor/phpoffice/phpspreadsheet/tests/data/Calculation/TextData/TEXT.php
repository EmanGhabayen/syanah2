<?php

return [
    [
        '$123.46',
        123.456,
        '$#,##0.00',
    ],
    [
        '$-123.46',
        -123.456,
        '$#,##0.00',
    ],
    [
        '123.46',
        123.456,
        '#,##0.00',
    ],
    [
        '123',
        123.456,
        '#,##0',
    ],
    [
        '00123',
        123.456,
        '00000',
    ],
    [
        '$123,456.79',
        123456.789,
        '$#,##0.00',
    ],
    [
        '123,456.79',
        123456.789,
        '#,##0.00',
    ],
    [
        '1.23E05',
        123456.789,
        '0.00E+00',
    ],
    [
        '-1.23E05',
        -123456.789,
        '0.00E+00',
    ],
    [
        '1.23E-05',
        1.2345E-5,
        '0.00E+00',
    ],
    [
        '1960-12-19',
        '19-Dec-1960',
        'yyyy-mm-dd',
    ],
    [
        '2012-01-01',
        '1-Jan-2012',
        'yyyy-mm-dd',
    ],
    [
        '1 3/4',
        1.75,
        '# ?/?',
    ],
];