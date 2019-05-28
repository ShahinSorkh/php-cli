<?php require dirname(__DIR__) . '/vendor/autoload.php';

cli\usage(
    [ 'args' => [ 'ARG1', 'ARG2', 'ARG3', 'ARG4', 'ARG5', 'ARG6', 'ARG7', 'ARG8' ] ],
    [
        'args' => [ 'SOURCE', 'URI', '[ID]' ],
        'opts' => [
            '-p' => 'PLUCK_BY1,PLUCK_BY2,..',
            '-t' => 'CONTENT_TYPE',
        ],
        'desc' => [
            '' => 'lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum. lorem ipsum.',
            'URI' => 'lorem ipsum',
            'SOURCE' => 'lorem ipsum',
            'ID' => 'Sit amet vero repellat vel officia. '
                . 'Suscipit enim laborum aperiam neque doloremque. '
                . 'Qui ea hic voluptatem dolor perspiciatis molestiae. '
                . 'Fuga enim ab qui ab suscipit. '
                . 'Consectetur voluptatibus dolore ad mollitia!',
            '-p' => 'lorem ipsum',
            '-t' => 'lorem ipsum',
        ],
    ],
    [
        'opts' => [
            '*c' => null,
            '-t' => 'CONTENT_TYPE',
        ],
        'desc' => [
            '-c' => 'lorem ipsum',
            '-t' => 'lorem ipsum',
        ],
    ]
);
