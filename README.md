# php-cli
Enhance php cli scripts experiance.

## Script Usage
Assuming following cli:

```sh
$ php script.php -f --action ACTION -- ARG1 ARG2 ARG3
```

### Count arguments

```php
cli\argc(); // returns 3
```

### Get arguments

```php
cli\arg(); // returns ['script.php', 'ARG1', 'ARG2', 'ARG3']
cli\arg(2); // returns 'ARG2'
cli\arg(4, 'foo'); // returns 'foo'
```

### Get options

```php
cli\opt(); // returns ['f' => true, 'action' => 'ACTION']
cli\opt('f'); // returns true
cli\opt('action'); // returns 'ACTION'
cli\opt('q'); // returns null
cli\opt('foo', 'bar'); // returns 'bar'
```

## Define usage
You can define a **strict** usage with **fixed** options and arguments.
To do so, you should use `cli\usage()` method which takes an array as
argument with possible keys of `args`, `opts`, `desc`.

### Define arguments
Arguments can be optional.

```php
cli\usage([
    'args' => [ 'REQUIRED_ARG', '[OPTIONAL_ARG]' ],
]);
```

### Define options
Options can be optional and can accept arguments.
Also options can be short or long.

```php
cli\usage([
    'opts' => [
        '-f' => null, // optional, without arg, short
        '*c' => null, // required, without arg, short
        '-o' => 'OPT_ARG', // optional, with arg, short
        '-no-dev' => null, // optional, without arg, long
        '*config' => 'CONFIG', // required, with arg, long
    ],
]);
```

### Define additional descriptions
If you need to describe about options or arguments, you can do so.

```php
cli\usage([
    'args' => [ 'CONFUSING_ARG' ],
    'opts' => [
        '-f' => null,
    ],
    'desc' => [
        'CONFUSING_ARG' => 'Some descriptions that make the arg not confusing!',
        '-f' => 'Describe -f option can force the operation or whatever.',
    ],
]);
```

## Command Line Usage
This package supports following syntax:

```sh
$ php script.php --opt --opt-with-arg OPT_ARG -- ARG [OPTIONAL_ARG]
```

### Passing arguments

- Arguments has to be the last values. This means the following syntax is not
acceptable:

```sh
$ php script.php ARG1 --opt1 ARG2 --opt2 OPT2_ARG ARG3 ARG4
```

Whenever an argument detected, every value after that is considered arguments.
Means all of `ARG1`, `--opt1`, `ARG2`, `--opt2`, `OPT2_ARG`, `ARG3`, `ARG4`,
are separate arguments.

- Every non-option value after an option, is considered the argument of the
option. This means in the following syntax, `ARG1` would be available as the
value of the `--op1` option (see below):

```sh
$ php script.php --op1 ARG1
```

If you need a boolean option and some arguments, use `--` before arguments.
like:

```sh
$ php script.php --op1 -- ARG1
```

- If you need input from `stdin`, use `-`. like:

```sh
$ php script.php - < somefile.txt
$ cat somefile.txt | php script.php -
```

It is possible to pass other arguments and options alongside.

### Passing options

Every passed value starting with `-` before the first detected argument, is an
option. Options can get additional value as **their** argument. like:

```sh
$ php script.php -f --file SOME_FILE
$ php customzipcompress.php --rm --compression best -f FILE1,FILE2 -d DIR1
```

If you are going to pass arguments, options **has to be terminated with `--`**. like:

```sh
$ php script.php -t -g OPT_ARG -- ARG1
```
