<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function create(User $user) { return
        $this->isAuthorized('transaction', 'create', $user);
    }

    public function view(User $user) { return
        $this->isAuthorized('transaction', 'view', $user);
    }

    public function export(User $user, Transaction $transaction) { return
        $this->isAuthorized('transaction', 'export', $user);
    }

    public function cash(User $user) { return
        $this->isAuthorized('transaction', 'cash', $user);
    }
}
