<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Content.aiintegration
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\Content\AiIntegration\Extension;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Utility\Utility;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\String\StringHelper;

// phpcs:disable PSR1.Files.SideEffects

\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

class AiIntegration extends CMSPlugin
{
    public function onContentPrepare($context, &$row, &$params, $page = 0)
    {
        $row->text = preg_replace_callback(
            '/\{ai\s+prompt="(.*?)"\}/', // Regular expression for matching {ai prompt="..."}
            function ($matches) {
                $prompt = $matches[1];
                
                // Here you would process the matched prompt with the replaceAiShortcode function
                $response = $this->replaceAiShortcode($matches[1]); // Replace the shortcode
                
                // Return the processed response to replace the shortcode
                return $response;
            },
            $row->text
        );

	}

    /**
     * Replace the {ai} shortcode with the AI response
     *
     * @param   array  $matches  The regular expression matches from the shortcode
     *
     * @return  string  The AI-generated response or an error message
     */
    public function replaceAiShortcode($matches)
    {
        // // Get the AI prompt from the shortcode match
        $prompt = $matches;

        // Call the helper to get the AI response
        $response = $this->getAiResponse($prompt);


        return $response;
    }

    /**
     * Get the AI response using the OpenAI API
     *
     * @param   string  $prompt  The prompt to send to the AI model
     *
     * @return  string  The AI response or an error message
     */
    public function getAiResponse($prompt)
    {
        $apiKey = 'your-api-key';
        $url = 'https://api.groq.com/openai/v1/chat/completions';

        // Prepare the POST data for the Groq model
        $postData = json_encode([
            'model' => 'llama-3.3-70b-versatile', // Specify the model (adjust if necessary)
            'messages' => [
                ['role' => 'user', 'content' => $prompt] // The user's prompt
            ]
        ]);
    
        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey, // Groq API key for authentication
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // Execute the cURL request
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error fetching AI response:  '. curl_error($ch);
            return 'Error fetching AI response';
        }

        // Close the cURL session
        curl_close($ch);

        // Parse the API response
        $responseData = json_decode($response, true);

        // Check if there are any errors in the response
        if (isset($responseData['error'])) {
            return 'Error: ' . $responseData['error']['message'];
        }

        // Extract the AI response from the correct path
        if (isset($responseData['choices'][0]['message']['content'])) {
            return trim($responseData['choices'][0]['message']['content']);
        }

        return 'Error: Groq response format invalid';
    }
}
