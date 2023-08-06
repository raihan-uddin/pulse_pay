<?php

return [
    'account_status' => [
        'active', // Account is fully active and functional
        'inactive', // Account is inactive or not yet activated
        'blocked', // Account is blocked due to violations or security concerns
        'closed', // Account has been permanently closed by the user
        'pending_verification', // Account registration is pending email/phone verification
        'pending_approval', // Account registration requires manual approval
        'limited_access', // Account has limited access to certain features
        'frozen', // Account is temporarily frozen due to suspicious activities
        'suspended', // Account is temporarily suspended due to violations or unresolved issues
        'overdue', // Account has overdue payments or debt
        'dormant', // Account is inactive for an extended period of time
        'under_review', // Account is under review for discrepancies or issues
        'deleted', // Soft delete status (you may use soft deletes to hide rather than physically delete)
        'unverified', // Account email/phone not verified
        'locked', // User self-locked their account
        'restricted', // Restricted access due to specific reasons
        'under_debt', // User has outstanding debt
        'terminated', // Account has been terminated permanently
    ],

    'transaction_status' => [
        'pending', // 'Transaction is awaiting processing or approval.',
        'completed', // 'Transaction has been successfully completed.',
        'failed', // 'Transaction has failed or encountered an error.',
        'cancelled', // 'Transaction has been cancelled by the user or system.',
        'refunded', // 'Transaction amount has been refunded to the user.',
        'on-hold', // 'Transaction is temporarily on hold for further processing.',
        'reversed', // 'Transaction has been reversed or rolled back.',
        'expired', // 'Transaction has expired and is no longer valid.',
        'processing', // 'Transaction is currently being processed.',
        'partially-completed', // 'Transaction has been partially completed.',
        'chargeback', // 'A chargeback request has been initiated for the transaction.',
        'voided', // 'Transaction has been voided.',
        'settled', // 'Transaction amount has been settled with the payment processor.',
        'declined', // 'Transaction has been declined by the payment gateway.',
        'authorized', // 'Transaction has been authorized but not yet captured.',
        'waiting-for-approval', // 'Transaction is waiting for manual approval.',
        'pending-verification', // 'Transaction is pending verification or additional checks.',
        'blocked', // 'Transaction has been blocked due to suspicious activity.',
        'partially-refunded', // 'Transaction amount has been partially refunded to the user.',
        'scheduled', // 'Transaction is scheduled for future processing.',
        'failed-insufficient-funds', // 'Transaction has failed due to insufficient funds.',
        'expired-token', // 'Transaction has expired due to the token being invalid.',
        'aborted', // 'Transaction has been aborted or terminated prematurely.',
        'completed-with-error', // 'Transaction was completed, but with some errors or warnings.',
        'recurring', // 'Transaction is part of a recurring payment schedule.',
    ],
];
