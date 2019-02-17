<?php declare(strict_types=1);

namespace AppBundle\Cache\Cloudflare;

class Client
{
    /**
     * @var string
     */
    private $authKey;
    /**
     * @var string
     */
    private $authEmail;
    /**
     * @var string
     */
    private $identifier;

    public function __construct(
        string $authKey,
        string $authEmail,
        string $identifier
    ) {
        $this->authKey = $authKey;
        $this->authEmail = $authEmail;
        $this->identifier = $identifier;
    }

    public function clearEverything(): void
    {
        $ch = curl_init();

        $url = sprintf('https://api.cloudflare.com/client/v4/zones/%s/purge_cache', $this->identifier);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['purge_everything' => true]));
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'X-Auth-Email: '.$this->authEmail;
        $headers[] = 'X-Auth-Key: '.$this->authKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \RuntimeException(curl_error($ch));
        }

        $data = json_decode($result, true);
        if (isset($data['success']) === false || $data['success'] !== true) {
            throw new \RuntimeException('Bad cloudflare response: '.$result);
        }

        curl_close($ch);
    }

}
