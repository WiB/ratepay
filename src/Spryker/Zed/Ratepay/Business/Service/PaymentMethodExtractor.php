<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Ratepay\Business\Service;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Ratepay\Business\Exception\NoPaymentMethodException;

class PaymentMethodExtractor
{

    /**
     * @var array
     */
    protected $paymentMethodsMap;

    /**
     * @param array $paymentMethodsMap
     */
    public function __construct($paymentMethodsMap)
    {
        $this->paymentMethodsMap = $paymentMethodsMap;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Transfer\AbstractTransfer|null
     * @throws NoPaymentMethodException
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
