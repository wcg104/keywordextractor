<?php

namespace Wcg\KeywordExtractor;

use App\Models\Stopword;
use Illuminate\Support\Facades\Response;


class KeywordExtractor
{



    /**
     * Extract keywords from a description text.
     *
     * This code takes a description and a language as input, processes the description to extract keywords, and provides an error response for certain conditions, such as an empty description or unsupported language. It also allows you to fetch stopwords from either a local configuration or a database source, depending on your setup. Finally, it sorts and returns the top keywords based on word frequency.
     * @param string $description The input description text.
     * @param string $language The language for stopwords (default: 'en').
     *
     * @return array An array of extracted keywords.
     */
    public function extractKeywords($description, $language = 'en')
    {
        if (empty($description)) {
            return $this->errorResponse('Description is required.', 400);
        }

        // Fetch stopwords from the configuration for the specified language        
        $source = config('keyword-extractor.stopword_source', 'local');

        if ($source === 'local') {

            // Fetch stopwords from the configuration for the specified language
            $stopwords = config('keyword-extractor.stopwords.' . $language, []);
        } elseif ($source === 'database') {

            // Fetch stopwords from the database for the specified language
            // Assuming you have a Stopword model and a corresponding Stopword table
            $stopwords = Stopword::where('language', $language)->pluck('word')->toArray();
        } else {
            return $this->errorResponse('Invalid stopword source.', 400);
        }

        if (empty($stopwords)) {
            return $this->errorResponse('Invalid language or language not supported.', 400);
        }

        // Convert to lowercase
        $description = strtolower($description);

        // Tokenize the description text
        $words = str_word_count($description, 1); // Include digits


        // Remove stopwords
        $filteredWords = array_diff($words, $stopwords);

        // Remove words with length less than 3 characters
        $filteredWords = array_filter($filteredWords, function ($word) {
            return strlen($word) >= 3;
        });

        // Count word frequencies
        $wordFrequencies = array_count_values($filteredWords);

        // Sort words by frequency (descending order)
        arsort($wordFrequencies);

        // Get the top N keywords
        $keywords = array_keys(array_slice($wordFrequencies, 0));

        return $keywords;
    }



    private function errorResponse($message, $statusCode)
    {
        return Response::json(['error' => $message], $statusCode);
    }
}
