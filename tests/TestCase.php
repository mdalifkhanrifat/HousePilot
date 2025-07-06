<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        // Enable foreign key constraints for SQLite
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON;');
        }
    }
}
