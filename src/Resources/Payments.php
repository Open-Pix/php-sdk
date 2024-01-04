<?php

namespace OpenPix\PhpSdk\Resources;

use OpenPix\PhpSdk\Paginator;
use OpenPix\PhpSdk\Request;
use OpenPix\PhpSdk\RequestTransport;

/**
 * Operations on payments.
 *
 * @link https://developers.openpix.com.br/api#tag/payment-(request-access)
 */
class Payments
{
    /**
     * Used to send HTTP requests to the payments API.
     * 
     * @var RequestTransport
     */
    private $requestTransport;

    /**
     * Create a new Payments instance.
     *
     * @param RequestTransport $requestTransport Used to send HTTP requests to the payments API.
     */
    public function __construct(RequestTransport $requestTransport)
    {
        $this->requestTransport = $requestTransport;
    }

    /**
     * Return an {@see Paginator} with payment list.
     *
     * ## Usage
     * ```php
     * $paginator = $client->payments()->list();
     *
     * foreach ($paginator as $result) {
     *      foreach ($result["payments"] as $payment) {
     *          $payment = $payment["payment"];
     *
     *          // Value of the requested payment in cents
     *          $payment["value"];
     *
     *          // The pix key the payment should be sent to.
     *          $payment["destinationAlias"];
     *
     *          // and more fields...
     *      }
     * }
     * ```
     *
     * @link https://developers.openpix.com.br/api#tag/payment-(request-access)/paths/~1api~1v1~1payment/get
     *
     * @param array<string, mixed> $queryParams Query parameters.
     *
     * @return Paginator Paginator with API results.
     */
    public function list(array $queryParams = []): Paginator
    {
        $request = (new Request())
            ->method("GET")
            ->path("/api/v1/payment")
            ->queryParams($queryParams);

        return new Paginator($this->requestTransport, $request);
    }

    /**
     * Get one payment by ID.
     *
     * ## Usage
     * ```php
     * $result = $client->payments()->getOne("paymentID");
     *
     * // value of the requested payment in cents
     * $result["payment"]["value"];
     *
     * // the pix key the payment should be sent to
     * $result["payment"]["destinationAlias"];
     *
     * // endToEndId of the transaction generated by the payment
     * $result["transaction"]["endToEndId"];
     *
     * // the tax id of the payment destination
     * $result["destination"]["taxID"];
     *
     * // and more fields...
     * ```
     *
     * @link https://developers.openpix.com.br/api#tag/payment-(request-access)/paths/~1api~1v1~1payment~1%7Bid%7D/get
     *
     * @param string $paymentID Payment ID or correlation ID.
     *
     * @return array<string, mixed> Result from API.
     */
    public function getOne(string $paymentID): array
    {
        $request = (new Request())
            ->method("GET")
            ->path("/api/v1/payment/" . $paymentID);

        return $this->requestTransport->transport($request);
    }

    /**
     * Request a payment.
     *
     * ## Usage
     * ```php
     * $result = $client->payments()->create([
     *      "value" => 0, // Value of the requested payment in cents.
     *      "destinationAlias" => "", // the pix key the payment should be sent to
     *      "correlationID" => "", // an unique identifier for your payment
     *      "comment" => "", // the comment that will be send alongisde your payment
     *      // an optional id for the source account of the payment,
     *      // if not informed will assume the default account
     *      "sourceAccountId" => "",
     * ]);
     *
     * $payment = $result["payment"];
     *
     * // Value of the requested payment in cents.
     * $payment["value"];
     *
     * // The pix key the payment should be sent to.
     * $payment["destinationAlias"];
     *
     * // Your correlation ID to keep track of this payment
     * $payment["correlationID"];
     *
     * // The comment that will be send alongisde your payment.
     * $payment["comment"];
     *
     * // Payment status.
     * // "CREATED", "FAILED", "CONFIRMED" or "DENIED".
     * $payment["status"];
     *
     * // The id of the payment source account.
     * $payment["sourceAccountId"];
     * ```
     *
     * @link https://developers.openpix.com.br/api#tag/payment-(request-access)/paths/~1api~1v1~1payment/post
     *
     * @param array<string, mixed> $payment Payment data.
     *
     * @return array<string, mixed> Result from API.
     */
    public function create(array $payment): array
    {
        $request = (new Request())
            ->method("POST")
            ->path("/api/v1/payment")
            ->body($payment);

        return $this->requestTransport->transport($request);
    }
}
