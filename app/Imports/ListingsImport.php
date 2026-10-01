<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Listing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ListingsImport implements ToCollection, WithHeadingRow
{
    public int $totalRows = 0;
    public int $importedRows = 0;
    public int $duplicateRows = 0;
    public int $invalidRows = 0;

    public array $errors = [];
    public array $duplicates = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // Excel row number.
            // Row 1 is the heading, so data starts at row 2.
            $excelRow = $index + 2;

            $this->totalRows++;

            /*
             * ---------------------------------------------------------
             * 1. Read and clean Excel values
             * ---------------------------------------------------------
             */

            $name = $this->clean($row['name'] ?? null);
            $cityName = $this->clean($row['city'] ?? null);
            $address = $this->clean($row['address'] ?? null);
            $phone = $this->clean($row['phone'] ?? null);
            $categoryName = $this->clean($row['category'] ?? null);

            /*
             * ---------------------------------------------------------
             * 2. Check required fields
             * ---------------------------------------------------------
             */

            $missing = [];

            if (!$name) {
                $missing[] = 'name';
            }

            if (!$cityName) {
                $missing[] = 'city';
            }

            if (!$address) {
                $missing[] = 'address';
            }

            if (!$phone) {
                $missing[] = 'phone';
            }

            if (!$categoryName) {
                $missing[] = 'category';
            }

            if (!empty($missing)) {

                $this->invalidRows++;

                $this->errors[] = [
                    'row' => $excelRow,
                    'reason' => 'Missing required field(s): ' . implode(', ', $missing),
                    'name' => $name,
                ];

                continue;
            }

            /*
             * ---------------------------------------------------------
             * 3. Find city
             * ---------------------------------------------------------
             *
             * We DO NOT automatically create cities.
             *
             * The city should already exist in the database.
             */

            $city = City::query()
                ->whereRaw(
                    'LOWER(TRIM(name)) = ?',
                    [Str::lower($cityName)]
                )
                ->first();

            if (!$city) {

                $this->invalidRows++;

                $this->errors[] = [
                    'row' => $excelRow,
                    'reason' => "City '{$cityName}' was not found.",
                    'name' => $name,
                ];

                continue;
            }

            /*
             * ---------------------------------------------------------
             * 4. Find OR create category
             * ---------------------------------------------------------
             *
             * If the category already exists:
             *
             *     use existing category
             *
             * If it does not exist:
             *
             *     create a new category
             *
             * We compare without caring about:
             *
             *     Computer
             *     computer
             *     COMPUTER
             *
             * They are treated as the same category.
             */

            $category = Category::query()
                ->whereRaw(
                    'LOWER(TRIM(name)) = ?',
                    [Str::lower($categoryName)]
                )
                ->first();

            if (!$category) {

                try {

                    $category = Category::create([
                        'name' => $categoryName,
                        'onDate' => now()->toDateString(),
                    ]);

                } catch (\Throwable $e) {

                    $this->invalidRows++;

                    $this->errors[] = [
                        'row' => $excelRow,
                        'reason' => 'Unable to create category: ' . $e->getMessage(),
                        'name' => $name,
                    ];

                    continue;
                }
            }

            /*
             * ---------------------------------------------------------
             * 5. Check for duplicate listing
             * ---------------------------------------------------------
             */

            $duplicate = Listing::query()
                ->where('cityId', $city->id)
                ->whereRaw(
                    'LOWER(TRIM(name)) = ?',
                    [Str::lower($name)]
                )
                ->whereRaw(
                    'TRIM(phone1) = ?',
                    [$phone]
                )
                ->exists();

            if ($duplicate) {

                $this->duplicateRows++;

                $this->duplicates[] = [
                    'row' => $excelRow,
                    'name' => $name,
                    'reason' => 'Listing already exists with the same name, city and phone.',
                ];

                continue;
            }

            /*
             * ---------------------------------------------------------
             * 6. Create listing and category relationship
             * ---------------------------------------------------------
             */

            try {

                DB::transaction(function () use (
                    $row,
                    $name,
                    $city,
                    $category,
                    $address,
                    $phone
                ) {

                    /*
                     * Create listing
                     */
                    $listing = Listing::create([

                        'name' => $name,

                        'cityId' => $city->id,

                        'add1' => $address,

                        'add2' => $this->clean(
                            $row['address2'] ?? null
                        ),

                        'email' => $this->clean(
                            $row['email'] ?? null
                        ),

                        'pobox' => $this->clean(
                            $row['po_box'] ?? null
                        ),

                        'phone1' => $phone,

                        'phone2' => $this->clean(
                            $row['phone2'] ?? null
                        ),

                        'fax' => $this->clean(
                            $row['fax'] ?? null
                        ),

                        'url' => $this->clean(
                            $row['website'] ?? null
                        ),

                        'description' => $this->clean(
                            $row['description'] ?? null
                        ),

                        'contact_person' => $this->clean(
                            $row['contact_person'] ?? null
                        ),

                        'latitude' => $this->clean(
                            $row['latitude'] ?? null
                        ),

                        'longitude' => $this->clean(
                            $row['longitude'] ?? null
                        ),

                        'status' => 'A',

                        'galleryStatus' => 'D',

                        'isPaid' => 'N',

                        'visited' => 0,

                        'onDate' => now()->toDateString(),
                    ]);

                    /*
                     * Connect listing to category
                     */
                    DB::table('listingcategories')->insert([
                        'listingId' => $listing->id,
                        'catId' => $category->id,
                    ]);
                });

                /*
                 * If everything above succeeds,
                 * count the row as successfully imported.
                 */
                $this->importedRows++;

            } catch (\Throwable $e) {

                /*
                 * Something went wrong while inserting
                 * the listing or category relationship.
                 */

                $this->invalidRows++;

                $this->errors[] = [
                    'row' => $excelRow,
                    'reason' => 'Database error: ' . $e->getMessage(),
                    'name' => $name,
                ];
            }
        }
    }

    /*
     * -------------------------------------------------------------
     * Clean Excel value
     * -------------------------------------------------------------
     */

    private function clean($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
