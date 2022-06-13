<?php return [
    [
        'name'       => 'google.com',
        'nameserver' => 'quad9',
        'types'      => ['a', 'aaaa', 'mx', 'ns', 'soa', 'txt'],
    ],
    [
        'name'       => 'comodo.com',
        'nameserver' => 'comodo',
        'types'      => ['caa'],
    ],
    [
        'name'       => 'www.dangibbs.uk',
        'nameserver' => 'cloudflare',
        'types'      => ['cname'],
    ],
    [
        'name'       => 'cloudflare.com',
        'nameserver' => 'cloudflare',
        'types'      => ['dnskey', 'ds'],
    ],
    [
        'name'       => '_submission._tcp.gmail.com',
        'nameserver' => 'opendns',
        'types'      => ['srv'],
    ],
    [
        'name'       => '10.34.239.216.in-addr.arpa',
        'nameserver' => 'google',
        'types'      => ['ptr'],
    ],
    [
        'name'       => '_443._tcp.mailbox.org',
        'nameserver' => 'opendns',
        'types'      => ['tlsa'],
    ],
];
