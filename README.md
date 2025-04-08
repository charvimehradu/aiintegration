# AI Integration Plugin
A Joomla! plugin that allows users to send a prompt to an AI model Groq, and receive a response that can be shown in Joomla! site. This integrates AI-generated content into Joomla articles using a simple shortcode. Developed as part of the **Project IV - Joomla AI Framework** selection task. 

## Overview
This plugin allows content creators to insert dynamic AI responses into Joomla articles by using a custom `{ai prompt="..."}` shortcode. The prompt is sent to the Groq API, and the response is rendered in place of the shortcode during article display.

## Prerequisites
- Joomla 4 or higher must be installed on your system. This might help if you are new to Joomla and want to explore more of it: [Setting Up Your Local Environment](https://docs.joomla.org/J4.x:Setting_Up_Your_Local_Environment).

## Installation Instructions
To install the Joomla extension for your Joomla Site follow the following steps:
1. Clone or download the zip file and extract the files on your desired location and copy the path of the folder.
  ![image](https://github.com/user-attachments/assets/8b525d01-5055-4264-b062-19cdab55fccf)

2. Log in to your Joomla! site's administrator area.

3. Navigate to the System -> Install -> Extensions -> Install from Folder. Paste the path of the installed folder here.
   ![image](https://github.com/charvimehradu/Category-Articles-JTask/assets/121369234/8f40bd89-1de8-4604-b7d2-9ec9842d135a)

Once completed with these steps, you should recieve the message "Installation of the module was successful." 

## API Key Configuration (Temporary Manual Step)
⚠️ Important: Before using the plugin, you need to add your Groq API key manually in the code.

Open the file:
  ```
  src/Extension/AiIntegration.php
  ```

Go to **line 75**, and replace the placeholder with your actual API key:
  ```
  $apiKey = 'your-api-key' // Replace with your real key
  ```

We are planning to improve this soon by allowing you to configure the API key via plugin parameters from the Joomla admin interface, making it more user-friendly and secure.

## ✨ How to Use

Once the plugin is installed and enabled, you can start using it right away.

1. **Enable the Plugin**:
   - Go to **System → Manage → Plugins**.
   - Search for `AI Integration`.
   - Click the plugin and make sure it is **enabled**.
2. Go to **Content → Articles**
3. Open an existing article or create a new one
4. Inside the article body, write text like format:
   ```text
   {ai prompt="<YourPrompt>"}
   ```
   Example:
   ```text
   {ai prompt="Tell me a joke"}
   ```
5. Save the article and view it on the frontend

The shortcode will be replaced by the AI-generated response.

## Demo


https://github.com/user-attachments/assets/be3dbe4a-375c-420f-b149-b81e7df88481


