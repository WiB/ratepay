<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Ratepay\Business\Service;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Ratepay\Business\Exception\NoPaymentMethodException;

class PaymentMethodExtractor implements PaymentMethodExtractorInterface
{

    /**
     * @var array
     */
    protected $paymentMethodsMap;

    /**
     * @param array $paymentMethodsMap
     */
    public function __construct(array $paymentMethodsMap)
    {
        $this->paymentMethodsMap = $paymentMethodsMap;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @throws \Spryker\Zed\Ratepay\Business\Exception\NoPaymentMethodException
     *
     * @return \Spryker\Shared\Transfer\AbstractTransfer|null
     */
    public function extractPaymentMethod(QuoteTransfer $quoteTransfer)
    {
        if (!$quoteTransfer->getPayment()) {
            return null;
        }
        $payment = $quoteTransfer->getPayment();
        $paymentMethodName = $payment->getPaymentMethod();
        if (!isset($this->paymentMethodsMap[$paymentMethodName])) {
            throw new NoPaymentMethodException();
        }
        $paymentMethodGet = 'get' . ucfirst($this->paymentMethodsMap[$paymentMethodName]);

        return $payment->$paymentMethodGet();
    }

}
