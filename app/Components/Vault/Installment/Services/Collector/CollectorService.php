<?php

namespace App\Components\Vault\Installment\Services\Collector;

use App\Components\Vault\Installment\Statement\Repositories\StatementRepositoryContract;
use App\Components\Vault\Installment\Statement\StatementContract;
use App\Components\Vault\Installment\Statement\Term\TermContract;
use App\Convention\Generators\Identity\IdentityGenerator;
use App\Convention\ValueObjects\Identity\Identity;
use Carbon\Carbon;

class CollectorService implements CollectorServiceContract
{
    /**
     * @var StatementRepositoryContract
     */
    private $repository;

    /** @var array */
    private $termToSign;

    /**
     * @param StatementRepositoryContract $repository
     */
    public function __construct(StatementRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param StatementContract $statement
     * @return StatementContract
     */
    private function trackTermUpdates(StatementContract $statement)
    {
        if ($this->termToSign) {
            $params = collect($this->termToSign);

            if ($statement->term() !== null) {
                $statement->term()->updateMonths($params->get('months'));
                $statement->term()->updateDeadlineDay($params->get('deadlineDay'));
                $statement->term()->updateMonthlyFee($params->get('monthlyFee'));
                $statement->term()->updateSetupFee($params->get('setupFee'));
            } else {
                app()->make(TermContract::class, $params->prepend(IdentityGenerator::next(), 'id')->put('statement', $statement)->toArray());
            }

            $this->termToSign = [];
        }

        return $statement;
    }
    /**
     * @param float $amount
     * @return string
     */
    public function signStatement(float $amount): string
    {
        $statement = app()->make(StatementContract::class, [
            'id' => IdentityGenerator::next(),
            'type' => 'credit',
            'amount' => $amount
        ]);

        $this->trackTermUpdates($statement);

        $statement = $this->repository->persist($statement);

        return (string) $statement->id();
    }

    /**
     * @param string $identity
     * @param float $amount
     * @return string
     */
    public function resignStatement(string $identity, float $amount): string
    {
        $statement = $this->repository->byIdentity(new Identity($identity));

        if ($statement) {
            $statement->updateAmount($amount);

            $this->trackTermUpdates($statement);

            $this->repository->persist($statement);

            return (string) $statement->id();
        }
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function rollbackStatement(string $identity): bool
    {
        // TODO: Implement rollbackStatement() method.
    }

    /**
     * @param string $identity
     * @return array
     */
    public function viewStatement(string $identity): array
    {
        $statement = $this->repository->byIdentity(new Identity($identity));

        if ($statement) {
            return [
                'id' => (string) $statement->id(),
                'amount' => $statement->amount(),
                'opened_at' => $statement->createdAt()->format('Y-m-d H:i:s'),
                'term' => [
                    'months' => $statement->term()->months(),
                    'deadline_date' => $statement->term()->deadlineDay(),
                    'setup_fee' => $statement->term()->setupFee(),
                    'monthly_fee' => $statement->term()->monthlyFee(),
                ]
            ];
        }
    }

    /**
     * @param int $months
     * @param int $paymentDeadlineDay
     * @param float $setupFee
     * @param float $monthlyFee
     * @return CollectorServiceContract
     */
    public function signTerm(
        int $months,
        int $paymentDeadlineDay,
        float $setupFee = 0.00,
        float $monthlyFee = 0.00
    ): CollectorServiceContract {
        $this->termToSign = [
            'months' => $months,
            'deadlineDay' => $paymentDeadlineDay,
            'setupFee' => $setupFee,
            'monthlyFee' => $monthlyFee,
        ];

        return $this;
    }
}