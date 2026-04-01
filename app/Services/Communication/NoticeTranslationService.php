<?php

namespace App\Services\Communication;

class NoticeTranslationService
{
    public function translateFromEnglish(string $message, string $targetLocale): string
    {
        // Stub for future AI translation integration.
        // Replace this with OpenAI/Azure Translator/Google Translate provider call.
        return sprintf('[%s translation pending] %s', strtoupper($targetLocale), $message);
    }
}
