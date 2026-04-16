<?php
/**
 * SkillBridge — Validator
 *
 * Fluent validation helper. Uses method chaining.
 * Call passes() to check; getErrors() to retrieve messages.
 */

declare(strict_types=1);

class Validator
{
    /** @var array<string, string> */
    private array $errors = [];

    // ── Rules ──────────────────────────────────────────────────────────────

    public function required(string $field, mixed $value): static
    {
        if ($value === null || trim((string) $value) === '') {
            $this->errors[$field] = ucfirst($field) . ' is required.';
        }
        return $this;
    }

    public function email(string $field, mixed $value): static
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Invalid email address.';
        }
        return $this;
    }

    public function minLength(string $field, mixed $value, int $min): static
    {
        if (!empty($value) && mb_strlen((string) $value) < $min) {
            $this->errors[$field] = ucfirst($field) . " must be at least {$min} characters.";
        }
        return $this;
    }

    public function maxLength(string $field, mixed $value, int $max): static
    {
        if (!empty($value) && mb_strlen((string) $value) > $max) {
            $this->errors[$field] = ucfirst($field) . " must not exceed {$max} characters.";
        }
        return $this;
    }

    public function inList(string $field, mixed $value, array $allowed): static
    {
        if (!empty($value) && !in_array($value, $allowed, true)) {
            $this->errors[$field] = ucfirst($field) . ' must be one of: ' . implode(', ', $allowed) . '.';
        }
        return $this;
    }

    public function url(string $field, mixed $value): static
    {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->errors[$field] = ucfirst($field) . ' must be a valid URL.';
        }
        return $this;
    }

    public function date(string $field, mixed $value): static
    {
        if (!empty($value)) {
            $d = DateTime::createFromFormat('Y-m-d', (string) $value);
            if (!$d || $d->format('Y-m-d') !== $value) {
                $this->errors[$field] = ucfirst($field) . ' must be a valid date (YYYY-MM-DD).';
            }
        }
        return $this;
    }

    public function notFutureDate(string $field, mixed $value): static
    {
        if (!empty($value)) {
            $d = DateTime::createFromFormat('Y-m-d', (string) $value);
            if ($d && $d > new DateTime()) {
                $this->errors[$field] = ucfirst($field) . ' cannot be in the future.';
            }
        }
        return $this;
    }

    public function futureDate(string $field, mixed $value): static
    {
        if (!empty($value)) {
            $d = DateTime::createFromFormat('Y-m-d', (string) $value);
            if ($d && $d <= new DateTime()) {
                $this->errors[$field] = ucfirst($field) . ' must be a future date.';
            }
        }
        return $this;
    }

    // ── Result ─────────────────────────────────────────────────────────────

    public function passes(): bool
    {
        return empty($this->errors);
    }

    /** @return array<string, string> */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
