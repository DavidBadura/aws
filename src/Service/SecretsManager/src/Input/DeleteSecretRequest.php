<?php

namespace AsyncAws\SecretsManager\Input;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Core\Input;
use AsyncAws\Core\Request;
use AsyncAws\Core\Stream\StreamFactory;

final class DeleteSecretRequest extends Input
{
    /**
     * The ARN or name of the secret to delete.
     *
     * @required
     *
     * @var string|null
     */
    private $secretId;

    /**
     * The number of days from 7 to 30 that Secrets Manager waits before permanently deleting the secret. You can't use both
     * this parameter and `ForceDeleteWithoutRecovery` in the same call. If you don't use either, then Secrets Manager
     * defaults to a 30 day recovery window.
     *
     * @var string|null
     */
    private $recoveryWindowInDays;

    /**
     * Specifies whether to delete the secret without any recovery window. You can't use both this parameter and
     * `RecoveryWindowInDays` in the same call. If you don't use either, then Secrets Manager defaults to a 30 day recovery
     * window.
     *
     * @var bool|null
     */
    private $forceDeleteWithoutRecovery;

    /**
     * @param array{
     *   SecretId?: string,
     *   RecoveryWindowInDays?: string,
     *   ForceDeleteWithoutRecovery?: bool,
     *
     *   @region?: string,
     * } $input
     */
    public function __construct(array $input = [])
    {
        $this->secretId = $input['SecretId'] ?? null;
        $this->recoveryWindowInDays = $input['RecoveryWindowInDays'] ?? null;
        $this->forceDeleteWithoutRecovery = $input['ForceDeleteWithoutRecovery'] ?? null;
        parent::__construct($input);
    }

    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getForceDeleteWithoutRecovery(): ?bool
    {
        return $this->forceDeleteWithoutRecovery;
    }

    public function getRecoveryWindowInDays(): ?string
    {
        return $this->recoveryWindowInDays;
    }

    public function getSecretId(): ?string
    {
        return $this->secretId;
    }

    /**
     * @internal
     */
    public function request(): Request
    {
        // Prepare headers
        $headers = [
            'Content-Type' => 'application/x-amz-json-1.1',
            'X-Amz-Target' => 'secretsmanager.DeleteSecret',
        ];

        // Prepare query
        $query = [];

        // Prepare URI
        $uriString = '/';

        // Prepare Body
        $bodyPayload = $this->requestBody();
        $body = empty($bodyPayload) ? '{}' : json_encode($bodyPayload, 4194304);

        // Return the Request
        return new Request('POST', $uriString, $query, $headers, StreamFactory::create($body));
    }

    public function setForceDeleteWithoutRecovery(?bool $value): self
    {
        $this->forceDeleteWithoutRecovery = $value;

        return $this;
    }

    public function setRecoveryWindowInDays(?string $value): self
    {
        $this->recoveryWindowInDays = $value;

        return $this;
    }

    public function setSecretId(?string $value): self
    {
        $this->secretId = $value;

        return $this;
    }

    private function requestBody(): array
    {
        $payload = [];
        if (null === $v = $this->secretId) {
            throw new InvalidArgument(sprintf('Missing parameter "SecretId" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['SecretId'] = $v;
        if (null !== $v = $this->recoveryWindowInDays) {
            $payload['RecoveryWindowInDays'] = $v;
        }
        if (null !== $v = $this->forceDeleteWithoutRecovery) {
            $payload['ForceDeleteWithoutRecovery'] = (bool) $v;
        }

        return $payload;
    }
}
