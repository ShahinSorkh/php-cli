<?php
namespace cli;

function usage(array ...$usages)
{
    if (!opt('help', false) && !opt('h', false)) {
        $possible_arg_counts = collect($usages)
            ->pluck('args')
            ->map(function ($args) {
                $required = collect($args)->filter(function ($a) { return preg_match('/^\w+$/', $a); });
                $optionals = collect($args)->filter(function ($a) { return preg_match('/^\[\w+\]$/', $a); });
                return collect([$required->count(), $required->merge($optionals)->count()]);
            });

        foreach ($possible_arg_counts as $i => $p)
            if (argc() >= $p->min() && argc() <= $p->max()) {
                $opts_set = collect(array_get($usages, "$i.opts", []));
                $required_opts = $opts_set
                    ->filter(function ($arg, $opt) { return $opt{0} === '*'; })->keys()
                    ->map(function ($o) { return implode('', array_slice(str_split($o), 1)); });

                $matches = 0;
                foreach ($required_opts as $opt) if (opt($opt)) $matches++;
                if ($matches !== $required_opts->count()) continue;

                $opts = $opts_set->keys()->map(function ($o) { return implode('', array_slice(str_split($o), 1)); });
                $opts_in = collect(array_keys(opt()));
                if (($diff = $opts_in->diff($opts)) && $diff->count()) continue;

                $opts_with_value = $opts_in
                    ->combine(
                        $opts->combine($opts_set->values())->only($opts_in)->values()
                    )
                    ->filter(function ($arg, $opt) { return $arg; })
                    ->keys();
                foreach ($opts_with_value as $opt) if (!is_string(opt($opt))) continue 2;

                return;
            }

        file_put_contents('php://stderr', '[ERR] Invalid arguments or options.' . PHP_EOL . PHP_EOL);
    }
    print_usage($usages);
}

function print_usage(array $usages)
{
    $use = '';
    foreach ($usages as $usage) {
        $use .= empty($use) ? "\tUSAGE: " : "\t       ";
        $opts = array_get($usage, 'opts', []);
        $args = array_get($usage, 'args', []);

        $use .= 'php ' . arg(0);
        foreach ($opts as $opt => $arg) {
            $required = $opt{0};
            $opt = implode('', array_slice(str_split($opt), 1));
            $opt = strlen($opt) === 1 ? "-$opt" : "--$opt";
            $opt_use = rtrim("$opt $arg");
            $use .= ' ' . ($required === '*' ? $opt_use:"[$opt_use]");
        }
        $use .= empty($opts) ? '':' --';
        foreach ($args as $arg)
            $use .= rtrim(" $arg");
        $use .= PHP_EOL;
    }

    file_put_contents(opt('help', false) || opt('h', false) ? 'php://stdout' : 'php://stderr', $use);
    exit(opt('help', false) || opt('h', false) ? 0 : 1);
}

function echo_w(string ...$strs)
{
    $cols = intval(`tput cols`);
    $str = implode('', $strs);
    printf("\r%s\r", str_limit(str_pad($str, $cols, ' '), $cols, ''));
}

function progress(int $total, int $process)
{
    $c = [
        'de' => "\033[0;00m", // default
        'bk' => "\033[0;30m", // black
        'dgr' => "\033[1;30m", // darkgray
        'rd' => "\033[0;31m", // red
        'lrd' => "\033[1;31m", // lightred
        'gr' => "\033[0;32m", // green
        'lgr' => "\033[1;32m", // lightgreen
        'br' => "\033[0;33m", // brown
        'yl' => "\033[1;33m", // yellow
        'bl' => "\033[0;34m", // blue
        'lbl' => "\033[1;34m", // lightblue
        'pp' => "\033[0;35m", // purple
        'lpp' => "\033[1;35m", // lightpurple
        'cy' => "\033[0;36m", // cyan
        'lcy' => "\033[1;36m", // lightcyan
        'gr' => "\033[0;37m", // gray
        'lgr' => "\033[1;37m", // lightgray
    ];

    $cols = intval(`tput cols`);
    $percent = $process / $total;
    $bar_length = $cols - 100;
    if ($bar_length > 5) {
        $filled = join(array_fill(0, floor($bar_length * $percent), '='));
        $bar = '['.str_pad("$c[gr]{$filled}$c[de]", $bar_length + strlen("$c[gr]$c[de]"), '-').']';
    } else $bar = '';
    echo_w(sprintf("    $c[br]%10d$c[de]/$c[b]%10d$c[de] %s ($c[b]%3d%%$c[de])", $process, $total, $bar, $percent * 100));
}

function argc()
{
    return count(get('args')) - 1;
}

function arg($index = null, $default = null)
{
    $args = get('args');

    if (is_null($index)) return $args;

    return array_get($args, $index, $default);
}

function opt($key = null, $default = null)
{
    $opts = get('opts');

    if (is_null($key)) return $opts;

    return array_get($opts, $key, $default);
}

function get($key = null)
{
    static $cli;
    if (!$cli) $cli = parse_args();

    if (is_null($key)) return $cli;
    if (!array_key_exists($key, $cli))
        die('invalid key');

    return $cli[$key];
}

function parse_args()
{
    global $argv;

    $cli = [
        'opts' => [],
        'args' => [basename(array_shift($argv))],
    ];

    for ($i = 0; $i < count($argv); $i++) {
        $arg = $argv[$i];

        // The special element '--' means explicit end of options. Treat the rest of the arguments as non-options
        // and end the loop.
        if ($arg == '--') {
            $cli['args'] = array_merge($cli['args'], array_slice($argv, $i + 1));
            break;
        }

        // '-' means stdin
        if ($arg == '-') {
            $cli['args'] = array_merge($cli['args'], [trim(file_get_contents('php://stdin'))], array_slice($argv, $i + 1));
            break;
        }

        // first non option arg
        if ($arg{0} != '-') {
            $cli['args'] = array_merge($cli['args'], array_slice($argv, $i));
            break;
        }

        $next_arg = $argv[$i + 1] ?? null;
        $has_value = is_string($next_arg) && $next_arg{0} !== '-';

        // long option
        if (strlen($arg) > 1 && $arg{1} == '-') {
            $opt = substr($arg, 2);
            $val = true;
            // argument required?
            if ($has_value) $val = $argv[++$i];
            $cli['opts'][$opt] = true;
            continue;
        }

        // short option
        $opt = substr($arg, 1);
        $val = true;
        // argument required?
        if ($has_value) $val = $argv[++$i];
        $cli['opts'][$opt] = $val;
    }

    return $cli;
}
