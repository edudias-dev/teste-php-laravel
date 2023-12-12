<?php

namespace App\Enums;

enum ProcessorStatusEnum
{
    public const PROCESSED = 'processed';
    public const PENDING = 'pending';
    public const CANCELED = 'canceled';
}
