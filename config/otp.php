<?php

return [
    'length' => (int) env('OTP_LENGTH', 6),
    'expiry_minutes' => (int) env('OTP_EXPIRY_MINUTES', 5),
    'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),
    'cooldown_seconds' => (int) env('OTP_COOLDOWN_SECONDS', 60),
    'max_requests_per_5min' => (int) env('OTP_MAX_REQUESTS_PER_5MIN', 3),
];
