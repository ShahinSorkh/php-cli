# php-cli
Usefull cli related functions for php

## CLI Syntax
This package supports following syntax:

```sh
$ php script.php --opt --opt-with-arg OPT_ARG -- ARG [OPTIONAL_ARG]
```

### Arguments

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

### Options

Every passed value starting with `-` before the first detected argument, is an
option. Options can get additional value as **their** argument. like:

```sh
$ php script.php -f --file SOME_FILE
$ php customzipcompress.php --rm --compression best -f FILE1,FILE2 -d DIR1
```

_to be continued.._
