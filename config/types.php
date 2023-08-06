<?php

return [
    'transaction_type' => [
        'deposit', // A transaction in which money is added to an account.
        'withdrawal', // A transaction in which money is removed from an account.
        'received', // A transaction in which money is received from an account.
        'transfer', // A transaction in which money is moved from one account to another.
        'payment', // A transaction in which money is sent to another party.
        'charge', // A transaction in which money is taken from an account for a service or product.
        'refund', // A transaction in which money is returned to an account after a charge has been made.
        'dispute', // A transaction that is challenged by one or more parties.
        'fee', // A charge that is applied to a transaction.
    ],

    'fee_type' => [
        'fixed', // Fixed amount transaction fee
        'percentage', // Percentage-based transaction fee
        'mixed', // Mixed fee type with fixed and percentage
    ],

    'transaction_method' => [
        'bank' => 'Bank Transfer',
        'bkash' => 'bKash',
        'nagad' => 'Nagad',
        'paypal' => 'PayPal',
        'credit_card' => 'Credit Card',
        'debit_card' => 'Debit Card',
        'net_banking' => 'Net Banking',
        'online' => 'Online',
    ],
];
