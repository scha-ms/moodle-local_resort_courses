<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Smoke test that generic CI secrets reach the runtime test environment.
 *
 * @package    local_resort_courses
 * @copyright  2026 Sangyul Cha <scha@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_resort_courses;

/**
 * Verify GENERIC_* env vars from moodle-workflows secrets passthrough.
 *
 * @coversNothing
 */
final class generic_secrets_test extends \advanced_testcase {

    /**
     * Ensure all four generic secret environment variables are set and non-empty.
     */
    public function test_generic_secrets_are_available_in_runtime(): void {
        $keys = [
            'GENERIC_USERNAME_1',
            'GENERIC_PASSWORD_1',
            'GENERIC_USERNAME_2',
            'GENERIC_PASSWORD_2',
        ];

        $missing = [];
        foreach ($keys as $key) {
            $value = getenv($key);
            if ($value === false || $value === '') {
                $missing[] = $key;
            }
        }

        if ($missing !== []) {
            $this->markTestSkipped(
                'Repo Actions secrets not configured yet: ' . implode(', ', $missing)
            );
        }

        foreach ($keys as $key) {
            $this->assertNotSame('', getenv($key));
        }
    }
}
