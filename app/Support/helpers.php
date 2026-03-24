<?php

if (! function_exists('feature_enabled')) {
    function feature_enabled(string $feature, bool $default = false): bool
    {
        return (bool) config("feature_flags.{$feature}", $default);
    }
}
