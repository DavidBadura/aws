<?php

namespace AsyncAws\Kms\Exception;

use AsyncAws\Core\Exception\Http\ClientException;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * The request was rejected because of the `ConnectionState` of the custom key store. To get the `ConnectionState` of a
 * custom key store, use the DescribeCustomKeyStores operation.
 * This exception is thrown under the following conditions:.
 *
 * - You requested the ConnectCustomKeyStore operation on a custom key store with a `ConnectionState` of `DISCONNECTING`
 *   or `FAILED`. This operation is valid for all other `ConnectionState` values. To reconnect a custom key store in a
 *   `FAILED` state, disconnect it (DisconnectCustomKeyStore), then connect it (`ConnectCustomKeyStore`).
 * - You requested the CreateKey operation in a custom key store that is not connected. This operations is valid only
 *   when the custom key store `ConnectionState` is `CONNECTED`.
 * - You requested the DisconnectCustomKeyStore operation on a custom key store with a `ConnectionState` of
 *   `DISCONNECTING` or `DISCONNECTED`. This operation is valid for all other `ConnectionState` values.
 * - You requested the UpdateCustomKeyStore or DeleteCustomKeyStore operation on a custom key store that is not
 *   disconnected. This operation is valid only when the custom key store `ConnectionState` is `DISCONNECTED`.
 * - You requested the GenerateRandom operation in an CloudHSM key store that is not connected. This operation is valid
 *   only when the CloudHSM key store `ConnectionState` is `CONNECTED`.
 */
final class CustomKeyStoreInvalidStateException extends ClientException
{
    protected function populateResult(ResponseInterface $response): void
    {
        $data = $response->toArray(false);

        if (null !== $v = (isset($data['message']) ? (string) $data['message'] : null)) {
            $this->message = $v;
        }
    }
}
