<?php

namespace App\Helpers;

class ClientLogoHelper
{
    /**
     * Get logo image paths (light/dark) for a client name.
     * Returns null if client not found.
     */
    public static function getLogo(string $clientName): ?array
    {
        $normalizedName = strtolower($clientName);

        $clients = [
            'chatgpt'    => ['light' => '/images/clients/chatgpt-light.png', 'dark' => '/images/clients/chatgpt-dark.png'],
            'claude'     => ['light' => '/images/clients/claude.png',         'dark' => '/images/clients/claude.png'],
            'cursor'     => ['light' => '/images/clients/cursor-light.png',   'dark' => '/images/clients/cursor-dark.png'],
            'vscode'     => ['light' => '/images/clients/vscode.png',         'dark' => '/images/clients/vscode.png'],
            'windsurf'   => ['light' => '/images/clients/windsurf-light.png', 'dark' => '/images/clients/windsurf-dark.png'],
            'perplexity' => ['light' => '/images/clients/perplexity-light.png','dark'=> '/images/clients/perplexity-dark.png'],
            'zed'        => ['light' => '/images/clients/zed.png',            'dark' => '/images/clients/zed.png'],
            'continue'   => ['light' => '/images/clients/continue.png',        'dark' => '/images/clients/continue.png'],
            'gemini'     => ['light' => '/images/clients/gemini.png',          'dark' => '/images/clients/gemini.png'],
            'cline'      => ['light' => '/images/clients/cline-light.png',     'dark' => '/images/clients/cline-dark.png'],
            'lm studio'  => ['light' => '/images/clients/lmstudio.webp',       'dark' => '/images/clients/lmstudio.webp'],
            'codeium'    => ['light' => '/images/clients/codeium.png',          'dark' => '/images/clients/codeium.png'],
            'copilot'    => ['light' => '/images/clients/copilot.png',         'dark' => '/images/clients/copilot.png'],
            'tabnine'    => ['light' => '/images/clients/tabnine.png',          'dark' => '/images/clients/tabnine.png'],
            'amazon q'   => ['light' => '/images/clients/amazon-q.png',         'dark' => '/images/clients/amazon-q.png'],
            'mistral'    => ['light' => '/images/clients/mistral.png',          'dark' => '/images/clients/mistral.png'],
            'groq'       => ['light' => '/images/clients/groq.png',             'dark' => '/images/clients/groq.png'],
            'ollama'     => ['light' => '/images/clients/ollama.png',           'dark' => '/images/clients/ollama.png'],
            'jan'        => ['light' => '/images/clients/jan.png',              'dark' => '/images/clients/jan.png'],
        ];

        foreach ($clients as $key => $paths) {
            if (str_contains($normalizedName, $key)) {
                return $paths;
            }
        }

        return null;
    }

    /**
     * Get brand color for a client name.
     */
    public static function getColor(string $clientName): string
    {
        $normalizedName = strtolower($clientName);

        $colors = [
            'chatgpt'    => '#10a37f',
            'claude'     => '#d97706',
            'cursor'     => '#22c55e',
            'vscode'     => '#007acc',
            'windsurf'   => '#6b7280',
            'perplexity' => '#6366f1',
            'zed'        => '#22c55e',
            'continue'   => '#8b5cf6',
            'gemini'     => '#f59e0b',
            'mcp client' => '#06b6d4',
        ];

        foreach ($colors as $key => $color) {
            if (str_contains($normalizedName, $key)) {
                return $color;
            }
        }

        return '#8b5cf6'; // default purple
    }

    public static function getLogoHtml(string $clientName, string $theme = 'dark'): string
    {
        $logos = self::getClientImages($theme);
        $normalizedName = strtolower($clientName);

        foreach ($logos as $name => $imagePath) {
            if (str_contains($normalizedName, strtolower($name))) {
                return '<img src="' . $imagePath . '" width="20" height="20" style="object-fit: contain; border-radius: 4px;" />';
            }
        }

        // Default logo with first letter - theme aware
        $firstLetter = strtoupper(substr($clientName, 0, 1));
        $gradient = $theme === 'light'
            ? 'background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);'
            : 'background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);';
        return '<span style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: white; ' . $gradient . ' border-radius: 4px;">' . $firstLetter . '</span>';
    }

    private static function getClientImages(string $theme = 'dark'): array
    {
        $lightLogos = [
            'ChatGPT' => '/images/clients/chatgpt-light.png',
            'Claude' => '/images/clients/claude.png',
            'Cursor' => '/images/clients/cursor-light.png',
            'VS Code' => '/images/clients/vscode.png',
            'Windsurf' => '/images/clients/windsurf-light.png',
            'Zed' => '/images/clients/zed.png',
            'Continue' => '/images/clients/continue.png',
            'Cline' => '/images/clients/cline-light.png',
            'Gemini' => '/images/clients/gemini.png',
            'LM Studio' => '/images/clients/lmstudio.webp',
            'Perplexity' => '/images/clients/perplexity-light.png',
            'Codeium' => '/images/clients/codeium.png',
            'Copilot' => '/images/clients/copilot.png',
            'Tabnine' => '/images/clients/tabnine.png',
            'Amazon Q' => '/images/clients/amazon-q.png',
            'Mistral' => '/images/clients/mistral.png',
            'Groq' => '/images/clients/groq.png',
            'Ollama' => '/images/clients/ollama.png',
            'Jan' => '/images/clients/jan.png',
        ];

        $darkLogos = [
            'ChatGPT' => '/images/clients/chatgpt-dark.png',
            'Claude' => '/images/clients/claude.png',
            'Cursor' => '/images/clients/cursor-dark.png',
            'VS Code' => '/images/clients/vscode.png',
            'Windsurf' => '/images/clients/windsurf-dark.png',
            'Zed' => '/images/clients/zed.png',
            'Continue' => '/images/clients/continue.png',
            'Cline' => '/images/clients/cline-dark.png',
            'Gemini' => '/images/clients/gemini.png',
            'LM Studio' => '/images/clients/lmstudio.webp',
            'Perplexity' => '/images/clients/perplexity-dark.png',
            'Codeium' => '/images/clients/codeium.png',
            'Copilot' => '/images/clients/copilot.png',
            'Tabnine' => '/images/clients/tabnine.png',
            'Amazon Q' => '/images/clients/amazon-q.png',
            'Mistral' => '/images/clients/mistral.png',
            'Groq' => '/images/clients/groq.png',
            'Ollama' => '/images/clients/ollama.png',
            'Jan' => '/images/clients/jan.png',
        ];

        return $theme === 'light' ? $lightLogos : $darkLogos;
    }
}
