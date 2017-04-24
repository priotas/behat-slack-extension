<?php

namespace Priotas\Behat;

class SlackChannel
{
    /**
     * Slack API base url
     */
    protected $baseUrl = "https://slack.com/api/";

    /**
     * SlackChannel constructor.
     * @param $token
     * @param $channel
     */
    public function __construct($token, $channel)
    {
        $this->token = $token;
        $this->channel = $channel;
    }

    public function curl(array $options)
    {
        $options[CURLOPT_RETURNTRANSFER] = true;
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $res = curl_exec($ch);
        if ($res === false) {
            $_errno = curl_errno($ch);
            $_error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("CURL Error: $_errno : $_error");
        }
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (($code != 200) && ($code != 204)) {
            throw new \Exception("Error code " . $code . ' returned.', $code);
        }
        return $res;
    }

    public function call($functionName, $options)
    {
        $options[CURLOPT_URL] = "{$this->baseUrl}$functionName?token={$this->token}&channel={$this->channel}";
        $res = $this->curl($options);
        $decoded = json_decode($res);
        if ($decoded === null) {
            throw new \Exception('something bad happened. ' . $res);
        }
        if ($decoded->ok !== true) {
            throw new \Exception('Slack returned Error: ' . $decoded->error);
        }
        return $decoded;
    }

    /**
     * documentation of postMessage: https://api.slack.com/methods/chat.postMessage
     * for attachment Structure see: https://api.slack.com/docs/attachments
     * response defined here: https://api.slack.com/types/file
     */
    public function postMessage($username, $text, array $attachments = null)
    {
        $fields = ["username" => $username, "text" => $text];
        if ($attachments !== null) {
            $fields['attachments'] = json_encode($attachments);
        }
        $options = array(
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $fields,
        );
        $res = $this->call("chat.postMessage", $options);
        return $res->message;
    }

    public function upload($filePath, $filename, $title)
    {
        $postfields = [
            'filename' => $filename,
            'channels' => $this->channel,
            'title' => $title,
            'file' => curl_file_create($filePath, 'image/png', $filename),
        ];

        $options = array(
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_INFILESIZE => filesize($filePath),
        );
        $res = $this->call('files.upload', $options);
        return $res->file;
    }
}
