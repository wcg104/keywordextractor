# Keyword Extractor Laravel Package

The Keyword Extractor Laravel package helps in extracting keywords from a given description text.

## Installation

1.  Install the package via Composer:

    ```bash
    composer require wcg/keyword-extractor
    ```

2.  Publish the configuration file:

    ```bash
    php artisan vendor:publish --provider="Wcg\KeywordExtractor\KeywordExtractorServiceProvider" --tag=keyword-extractor-config
    ```

    This will publish the package configuration file to `config/keyword-extractor.php`. You can modify the configuration as needed.

3.  Configure the package:

    Update `config/keyword-extractor.php` to set the appropriate stopword source and languages.

4.  (Optional) Setup stopword database source:

    If using a database as the stopword source, configure the database connection and create one table 'stopwords'.

    ### Table Name: `stopwords`

        | Column Name | Data Type | Description                  |
        |-------------|-----------|------------------------------|
        | id          | int       | Primary key                  |
        | language    | string    | Language code (e.g., 'en')   |
        | word        | string    | Stopword                     |
        | created_at  | timestamp | Timestamp of creation        |
        | updated_at  | timestamp | Timestamp of last update     |

    ### Example Data

        | id | language | word      | created_at           | updated_at           |
        |----|----------|-----------|----------------------|----------------------|
        | 1  | en       | the       | 2023-09-15 12:34:56   | 2023-09-15 12:34:56   |
        | 2  | en       | and       | 2023-09-15 12:34:57   | 2023-09-15 12:34:57   |
        | 3  | fr       | le        | 2023-09-15 12:34:58   | 2023-09-15 12:34:58   |
        | 4  | fr       | la        | 2023-09-15 12:34:59   | 2023-09-15 12:34:59   |

## Configuration

The package allows for basic customization via the configuration file. The `config/keyword-extractor.php` file contains options such as supported languages and other settings.

## Usage

1. Import the `KeywordExtractor` class:

   ```php
   use Wcg\KeywordExtractor\KeywordExtractor;
   ```

2. Create an instance of the `KeywordExtractor`:

   ```php
   $extractor = new KeywordExtractor();
   ```

3. Extract keywords from a description:

   ```php
   $description = "A fantastic opportunity to purchase a private detached charming country residence...";
   $language = 'en';
   $keywords = $extractor->extractKeywords($description,$language);
   ```

   Replace `$description` with the actual description from which you want to extract keywords.

4. Use the extracted keywords as needed:

   ```php
   // Example: Display extracted keywords
   print_r($keywords);
   ```

## License

This package is open-source and licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
