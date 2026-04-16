<?php
/**
 * SkillBridge — Sanitizer
 *
 * Strips dangerous characters from user input before storage or output.
 * Always call AFTER validation, not instead of it.
 */

declare(strict_types=1);

class Sanitizer
{
    /** Remove HTML special chars and trim whitespace. */
    public static function string(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /** Sanitize an email address string. */
    public static function email(string $value): string
    {
        return (string) filter_var(trim($value), FILTER_SANITIZE_EMAIL);
    }

    /** Cast to integer safely. */
    public static function int(mixed $value): int
    {
        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /** Sanitize a URL string. */
    public static function url(string $value): string
    {
        return (string) filter_var(trim($value), FILTER_SANITIZE_URL);
    }

    /** Return a boolean from a truthy/falsy value. */
    public static function bool(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN) === true;
    }
}
