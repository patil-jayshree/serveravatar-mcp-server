<?php

namespace App\Helpers;

class ClientLogoHelper
{
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
