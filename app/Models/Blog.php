<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'image',
        'description'
    ];

    public function getFullTitleAttribute(): string
    {
        $title = $this->extractTitle();

        return $title !== ''
            ? Str::limit($title, 150, '...')
            : 'BJDD Journal Blog';
    }

    public function getDisplayTitleAttribute(): string
    {
        return Str::limit($this->full_title, 120, '...');
    }

    public function getExcerptAttribute(): string
    {
        $body = $this->cleanText($this->article_html);

        if ($body === '') {
            $body = $this->cleanText($this->description);
        }

        $body = preg_replace('/^' . preg_quote($this->full_title, '/') . '\s*/iu', '', $body);

        return Str::limit(trim($body) ?: $this->full_title, 240, '...');
    }

    public function getArticleHtmlAttribute(): string
    {
        return $this->withoutLeadingTitle($this->cleanHtml($this->description));
    }

    private function extractTitle(): string
    {
        $description = trim((string) $this->description);

        if ($description === '') {
            return '';
        }

        if (preg_match('/<(h[1-6]|strong|b|p|div)[^>]*>(.*?)<\/\1>/is', $description, $matches)) {
            $headline = $this->headlineFromText($matches[2]);

            if ($headline !== '') {
                return $headline;
            }
        }

        return $this->headlineFromText($description);
    }

    private function headlineFromText(?string $value): string
    {
        $text = (string) $value;
        $text = preg_replace('/<(br\s*\/?|\/p|\/div|\/h[1-6])[^>]*>/i', "\n", $text);
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $parts = preg_split('/(?:\R+|[_=\-]{5,}|\.{5,}|(?:\x{2022}){2,})/u', $text) ?: [];

        foreach ($parts as $part) {
            $headline = $this->cleanText($part);

            if ($headline !== '' && Str::length($headline) >= 8) {
                return $headline;
            }
        }

        return $this->cleanText($text);
    }

    private function cleanText(?string $value): string
    {
        $text = html_entity_decode(strip_tags($value ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/(?:[_=\-]{5,}|\.{5,}|(?:\x{2022}){2,})/u', ' ', $text);
        $text = preg_replace('/\s+/u', ' ', $text);
        $text = preg_replace('/^(?:\s|[._=\-]|\x{2022})+|(?:\s|[._=\-]|\x{2022})+$/u', '', $text);

        return trim($text);
    }

    private function cleanHtml(?string $value): string
    {
        $html = trim((string) $value);

        if ($html === strip_tags($html)) {
            $text = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text = preg_replace('/(?:[_=\-]{5,}|\.{5,}|(?:\x{2022}){2,})/u', "\n", $text);

            return $this->plainTextToHtml($text);
        }

        $html = preg_replace('/<p[^>]*>\s*(?:&nbsp;|\s|[_=\-.]|\x{2022}){5,}\s*<\/p>/iu', '', $html);
        $html = preg_replace('/(?:[_=\-]{5,}|\.{5,}|(?:\x{2022}){2,})/u', ' ', $html);

        return trim($html);
    }

    private function plainTextToHtml(string $text): string
    {
        $paragraphs = preg_split('/\R/u', trim($text)) ?: [];
        $paragraphs = array_values(array_filter(array_map(
            fn ($paragraph) => $this->cleanText($paragraph),
            $paragraphs
        )));
        $html = '';
        $count = count($paragraphs);

        for ($i = 0; $i < $count; $i++) {
            $paragraph = $paragraphs[$i];

            if ($this->isSectionHeading($paragraph)) {
                $html .= '<h2>' . $this->escapeHtml($paragraph) . '</h2>';
                continue;
            }

            $html .= '<p>' . $this->escapeHtml($paragraph) . '</p>';

            if ($this->introducesList($paragraph) && $this->hasListAfter($paragraphs, $i + 1)) {
                $html .= '<ul>';

                while (($paragraphs[$i + 1] ?? null) && $this->isListItemCandidate($paragraphs[$i + 1])) {
                    $i++;
                    $html .= '<li>' . $this->escapeHtml($this->normalizeListItem($paragraphs[$i])) . '</li>';
                }

                $html .= '</ul>';
            }
        }

        return $html;
    }

    private function escapeHtml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function introducesList(string $line): bool
    {
        return Str::endsWith($line, ':');
    }

    private function hasListAfter(array $paragraphs, int $index): bool
    {
        return isset($paragraphs[$index]) && $this->isListItemCandidate($paragraphs[$index]);
    }

    private function isSectionHeading(string $line): bool
    {
        if (Str::length($line) > 130 || Str::endsWith($line, ':')) {
            return false;
        }

        if (preg_match('/^step\s+\d+\s*[:.-]/iu', $line)) {
            return true;
        }

        return Str::endsWith($line, '?')
            && preg_match('/^(what|why|how|when|where|who|which)\b/iu', $line);
    }

    private function isListItemCandidate(string $line): bool
    {
        if ($this->isSectionHeading($line) || $this->introducesList($line)) {
            return false;
        }

        if (preg_match('/^(?:[-*]|\x{2022}|\d+[.)])\s+/u', $line)) {
            return true;
        }

        if (Str::length($line) > 120 || preg_match('/[.!?]$/u', $line)) {
            return false;
        }

        return str_word_count($line) <= 12;
    }

    private function normalizeListItem(string $line): string
    {
        return trim(preg_replace('/^(?:[-*]|\x{2022}|\d+[.)])\s*/u', '', $line) ?? $line);
    }

    private function withoutLeadingTitle(string $html): string
    {
        $title = $this->extractTitle();

        if ($title === '') {
            return $html;
        }

        return preg_replace_callback('/^\s*<(h[1-6]|p|div)[^>]*>(.*?)<\/\1>/is', function ($matches) use ($title) {
            $firstBlock = Str::lower($this->cleanText($matches[2]));
            $titleText = Str::lower($this->cleanText($title));

            if ($firstBlock === $titleText) {
                return '';
            }

            if (Str::startsWith($firstBlock, $titleText)) {
                $remainingText = preg_replace('/^' . preg_quote($this->cleanText($title), '/') . '\s*/iu', '', $this->cleanText($matches[2]));
                $remainingText = trim($remainingText ?? '');

                return $remainingText === ''
                    ? ''
                    : '<p>' . htmlspecialchars($remainingText, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
            }

            return $matches[0];
        }, $html, 1) ?? $html;
    }
}
