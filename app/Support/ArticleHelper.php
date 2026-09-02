<?php

namespace App\Support;

use App\Models\Publication;
use App\Models\BusinessSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ArticleHelper
{
    public const JOURNAL_NAME = 'Bodhivruksha Journal of Diverse Discipline';

    private static ?array $slugCounts = null;
    private static ?string $coverUrl = null;

    public static function slugForTitle(?string $title): string
    {
        return Str::slug($title ?: 'article') ?: 'article';
    }

    /**
     * Generate a readable key and add the record id only where duplicate titles need it.
     * This avoids a schema change while keeping existing records addressable.
     */
    public static function routeKey(Publication $publication): string
    {
        $base = self::slugForTitle($publication->paper_title);

        if (! $publication->exists || ! $publication->paper_title) {
            return $base;
        }

        if (self::$slugCounts === null) {
            self::$slugCounts = Publication::query()
                ->get(['paper_title'])
                ->countBy(fn (Publication $record) => self::slugForTitle($record->paper_title))
                ->all();
        }

        $duplicateCount = self::$slugCounts[$base] ?? 0;

        return $duplicateCount > 1 ? $base . '-' . $publication->getKey() : $base;
    }

    public static function findByRouteKey(string $key): ?Publication
    {
        if (ctype_digit($key)) {
            return Publication::find((int) $key);
        }

        if (preg_match('/-(\d+)$/', $key, $matches)) {
            $publication = Publication::find((int) $matches[1]);

            if ($publication && self::routeKey($publication) === $key) {
                return $publication;
            }
        }

        return Publication::query()
            ->get()
            ->first(fn (Publication $publication) => self::routeKey($publication) === $key);
    }

    public static function normalizeDoi(?string $doi): ?string
    {
        $doi = trim((string) $doi);

        if ($doi === '') {
            return null;
        }

        return preg_replace(
            '/^(?:https?:\/\/)?(?:dx\.)?doi\.org\//i',
            '',
            preg_replace('/^doi:\s*/i', '', $doi)
        );
    }

    public static function doiUrl(?string $doi): ?string
    {
        $normalized = self::normalizeDoi($doi);

        return $normalized ? 'https://doi.org/' . $normalized : null;
    }

    public static function journalCoverUrl(): string
    {
        if (self::$coverUrl !== null) {
            return self::$coverUrl;
        }

        try {
            if (Schema::hasTable('business_settings')) {
                $cover = BusinessSetting::where('key', 'home_cover')->value('value');

                if ($cover) {
                    return self::$coverUrl = asset('storage/app/public/' . ltrim($cover, '/'));
                }
            }
        } catch (\Throwable $exception) {
            // The existing logo remains a safe fallback when optional settings are unavailable.
        }

        return self::$coverUrl = asset('public/assets/img/bjdd logo.png');
    }

    public static function issueCoverUrl(?string $coverImage): ?string
    {
        if (! $coverImage) {
            return null;
        }

        if (filter_var($coverImage, FILTER_VALIDATE_URL)) {
            return $coverImage;
        }

        return asset('storage/app/public/' . ltrim($coverImage, '/'));
    }

    /** @return array<int, string> */
    public static function authors(?string $value): array
    {
        $value = trim(preg_replace('/\s+/', ' ', (string) $value));

        if ($value === '') {
            return [];
        }

        $value = preg_replace('/\s*(?:;|\s+&\s+|\s+and\s+)\s*/i', ',', $value);

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    public static function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY);

        if (count($parts) < 2) {
            return $name;
        }

        $surname = array_pop($parts);
        $initials = array_map(fn (string $part) => strtoupper(substr($part, 0, 1)) . '.', $parts);

        return $surname . ', ' . implode(' ', $initials);
    }

    public static function apaAuthors(array $authors): string
    {
        $formatted = array_map(function (string $author): string {
            $parts = preg_split('/\s+/', trim($author), -1, PREG_SPLIT_NO_EMPTY);
            $surname = array_pop($parts);
            $initials = array_map(fn (string $part) => strtoupper(substr($part, 0, 1)) . '.', $parts ?: []);

            return $surname . ($initials ? ', ' . implode(' ', $initials) : '');
        }, $authors);

        return self::joinAuthors($formatted, true);
    }

    public static function mlaAuthors(array $authors): string
    {
        $formatted = array_values(array_map(function (string $author, int $index): string {
            if ($index !== 0) {
                return $author;
            }

            $parts = preg_split('/\s+/', trim($author), -1, PREG_SPLIT_NO_EMPTY);
            $surname = array_pop($parts);

            return $surname . ($parts ? ', ' . implode(' ', $parts) : '');
        }, $authors, array_keys($authors)));

        return self::joinAuthors($formatted, false);
    }

    public static function ieeeAuthors(array $authors): string
    {
        $formatted = array_map(function (string $author): string {
            $parts = preg_split('/\s+/', trim($author), -1, PREG_SPLIT_NO_EMPTY);
            $surname = array_pop($parts);
            $initials = array_map(fn (string $part) => strtoupper(substr($part, 0, 1)) . '.', $parts ?: []);

            return ($initials ? implode(' ', $initials) . ' ' : '') . $surname;
        }, $authors);

        return implode(', ', $formatted);
    }

    public static function citation(Publication $publication, string $style): string
    {
        $authors = self::authors($publication->author_name);
        $authors = $authors ?: ['Unknown author'];
        $year = $publication->year ?: 'n.d.';
        $title = trim((string) $publication->paper_title);
        $journal = self::JOURNAL_NAME;
        $volume = $publication->volume ?: '';
        $issue = $publication->issue ? '(' . $publication->issue . ')' : '';
        $pages = $publication->page_nos ? ', ' . $publication->page_nos : '';
        $doi = self::doiUrl($publication->crossref_doi);
        $doiSuffix = $doi ? '. ' . $doi : '';

        return match (strtolower($style)) {
            'mla' => self::mlaAuthors($authors) . '. "' . $title . '." ' . $journal . ', vol. ' . $volume . ', no. ' . ($publication->issue ?: '') . ', ' . $year . $pages . '.' . $doiSuffix,
            'chicago' => self::mlaAuthors($authors) . '. "' . $title . '." ' . $journal . ' ' . $volume . ($issue ? ', no. ' . ($publication->issue ?: '') : '') . ' (' . $year . ')' . $pages . '.' . $doiSuffix,
            'ieee' => self::ieeeAuthors($authors) . ', "' . $title . '," ' . $journal . ', vol. ' . $volume . ($issue ? ', no. ' . ($publication->issue ?: '') : '') . $pages . ', ' . $year . '.' . ($doi ? ' doi: ' . $doi . '.' : ''),
            'harvard' => self::harvardAuthors($authors) . ' (' . $year . ') "' . $title . '", ' . $journal . ', ' . $volume . $issue . $pages . '.' . ($doi ? ' Available at: ' . $doi . '.' : ''),
            'vancouver' => self::vancouverAuthors($authors) . '. ' . $title . '. ' . $journal . '. ' . $year . ';' . $volume . ($issue ? '(' . ($publication->issue ?: '') . ')' : '') . ($publication->page_nos ? ':' . $publication->page_nos : '') . '.' . ($doi ? ' doi:' . $doi . '.' : ''),
            default => self::apaAuthors($authors) . ' (' . $year . '). ' . $title . '. ' . $journal . ', ' . $volume . $issue . $pages . '.' . $doiSuffix,
        };
    }

    /** @return array<string, string> */
    public static function citations(Publication $publication): array
    {
        return [
            'APA 7' => self::citation($publication, 'apa'),
            'MLA 9' => self::citation($publication, 'mla'),
            'Chicago' => self::citation($publication, 'chicago'),
            'IEEE' => self::citation($publication, 'ieee'),
            'Harvard' => self::citation($publication, 'harvard'),
            'Vancouver' => self::citation($publication, 'vancouver'),
        ];
    }

    private static function harvardAuthors(array $authors): string
    {
        $formatted = array_map(function (string $author): string {
            $parts = preg_split('/\s+/', trim($author), -1, PREG_SPLIT_NO_EMPTY);
            $surname = array_pop($parts);
            $initials = array_map(fn (string $part) => strtoupper(substr($part, 0, 1)), $parts ?: []);

            return $surname . ($initials ? ', ' . implode('', $initials) : '');
        }, $authors);

        return self::joinAuthors($formatted, false);
    }

    private static function vancouverAuthors(array $authors): string
    {
        return implode(', ', array_map(function (string $author): string {
            $parts = preg_split('/\s+/', trim($author), -1, PREG_SPLIT_NO_EMPTY);
            $surname = array_pop($parts);

            return $surname . ($parts ? ' ' . implode('', array_map(fn (string $part) => strtoupper(substr($part, 0, 1)), $parts)) : '');
        }, $authors));
    }

    private static function joinAuthors(array $authors, bool $ampersand): string
    {
        if (count($authors) < 2) {
            return $authors[0] ?? '';
        }

        if (count($authors) === 2) {
            return $authors[0] . ($ampersand ? ', & ' : ' and ') . $authors[1];
        }

        $last = array_pop($authors);

        return implode(', ', $authors) . ($ampersand ? ', & ' : ', and ') . $last;
    }
}
