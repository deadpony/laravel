<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Calendar\CalendarImmutable;
use App\Components\Vault\Fractional\Agreement\Statement\StatementImmutable;
use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Components\Vault\Outbound\Payment\PaymentContract;
use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fractional_agreements")
 */
class AgreementEntity implements AgreementContract
{
    /**
     * @var Identity
     * @ORM\Id
     * @ORM\Column(type="identity",unique=true)
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(type="float",nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime",nullable=false,name="created_at")
     */
    private $createdAt;

    /**
     * @var TermContract|null;
     * @ORM\OneToOne(targetEntity="App\Components\Vault\Fractional\Agreement\Term\TermEntity", mappedBy="agreement", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     */
    private $term;

    /**
     * @var ArrayCollection;
     * @ORM\ManyToMany(targetEntity="App\Components\Vault\Outbound\Payment\PaymentEntity", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     * @ORM\JoinTable(name="fractional_agreements_outbound_payments",
     *      joinColumns={@ORM\JoinColumn(name="fractional_agreement_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="outbound_payment_id", referencedColumnName="id", unique=true)})
     */
    private $payments;

    /**
     * @param Identity $id
     * @param float $amount
     * @param TermContract|null $term
     */
    public function __construct(Identity $id, float $amount, TermContract $term = null)
    {
        $this->id = $id;
        $this->setAmount($amount);

        $this->term = $term;

        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();

        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @param float $amount
     * @return AgreementEntity
     * @throws \InvalidArgumentException
     */
    private function setAmount(float $amount): AgreementEntity
    {
        if ($amount > 0 === false) {
            throw new \InvalidArgumentException("Amount can't be a zero value");
        }

        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Identity
     */
    public function id(): Identity
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return TermContract|null
     */
    public function term()
    {
        return $this->term;
    }

    /**
     * @param TermContract $term
     * @return AgreementContract
     */
    public function assignTerm(TermContract $term): AgreementContract
    {
        if ($this->term() instanceof TermContract) {
            throw new \InvalidArgumentException("Term already assigned");
        }

        $this->term = $term;

        return $this;
    }

    /**
     * @return array
     */
    public function payments(): array
    {
        return $this->payments->toArray();
    }

    /**
     * @param PaymentContract $payment
     * @return bool
     */
    public function pay(PaymentContract $payment): bool
    {
        $key = collect($this->payments->toArray())
            ->search(function (PaymentContract $paidPayment) use ($payment) {
                return $paidPayment->id()->equals($payment->id());
            });

        if ($key === false) {
            $this->payments->add($payment);
        }

        return true;
    }

    /**
     * @return PaymentContract
     */
    public function lastPayment(): PaymentContract
    {
        return collect($this->payments->toArray())
            ->sortByDesc(function (PaymentContract $paidPayment) {
                return $paidPayment->createdAt();
            })->first();
    }

    /**
     * @param CalendarImmutable $date
     * @return array
     */
    public function paymentsByMonthlyDeadline(CalendarImmutable $deadlineDate): array
    {
        return collect($this->payments->toArray())
            ->sortByDesc(function (PaymentContract $paidPayment) {
                return $paidPayment->createdAt();
            })->reject(function (PaymentContract $paidPayment) use ($deadlineDate) {
                return !$deadlineDate->inRange($paidPayment->createdAt());
            })->toArray();
    }

    /**
     * @param CalendarImmutable $date
     * @return array
     */
    public function paymentsByBoundaryDeadline(CalendarImmutable $deadlineDate): array
    {
        return collect($this->payments->toArray())
            ->sortByDesc(function (PaymentContract $paidPayment) {
                return $paidPayment->createdAt();
            })->reject(function (PaymentContract $paidPayment) use ($deadlineDate) {

                return
                    $paidPayment->createdAt()->getTimestamp() > $deadlineDate->deadlineTimestamp()
                    ||
                    $paidPayment->createdAt()->getTimestamp() < $this->term()->firstPaymentDeadlineDate()->beginningTimestamp();
            })->toArray();
    }

    /**
     * @param CalendarImmutable $date
     * @return array
     */
    public function paymentsByBoundaryBeginning(CalendarImmutable $deadlineDate): array
    {
        return collect($this->payments->toArray())
            ->sortByDesc(function (PaymentContract $paidPayment) {
                return $paidPayment->createdAt();
            })->reject(function (PaymentContract $paidPayment) use ($deadlineDate) {
                return
                    $paidPayment->createdAt()->getTimestamp() > $deadlineDate->beginningTimestamp()
                    ||
                    $paidPayment->createdAt()->getTimestamp() < $this->term()->firstPaymentDeadlineDate()->beginningTimestamp();
            })->toArray();
    }

    /**
     * @param array $payments
     * @return float
     */
    public function totalPaid(array $payments = []): float
    {
        return collect($payments ?? $this->payments)->sum(function (PaymentContract $payment) {
            return $payment->amount();
        });
    }

    /**
     * @param PaymentContract $payment
     * @return bool
     */
    public function refund(PaymentContract $payment): bool
    {
        $key = collect($this->payments->toArray())->search(function (PaymentContract $paidPayment) use ($payment) {
            return $paidPayment->id()->equals($payment->id());
        });

        if ($key !== false) {
            $this->payments->remove($key);
        }

        return true;
    }

    /**
     * @param float $amount
     * @return AgreementContract
     */
    public function updateAmount(float $amount): AgreementContract
    {
        $this->setAmount($amount);

        return $this;
    }

    /**
     * @return float
     */
    public function basePayment(): float
    {
        return floatval($this->amount() / $this->term()->months());
    }

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return float
     */
    public function definedPayment(CalendarImmutable $calendarDeadlineDate): float
    {
        $shouldBePaidUntilDeadline = $this->basePayment() * $this->term()->getCalendarDeadlineSerial($calendarDeadlineDate);
        $totalPaidUntilDeadline = $this->totalPaid($this->paymentsByBoundaryDeadline($calendarDeadlineDate));

        $difference = max(($this->amount() - $shouldBePaidUntilDeadline - $totalPaidUntilDeadline) + $this->basePayment(),
            0);

        return $difference > $this->basePayment() ? $this->basePayment() : $difference;
    }

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return float
     */
    public function leftoverPayment(CalendarImmutable $calendarDeadlineDate): float
    {
        // todo: correct leftover
        return 0.00;
    }

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return float
     */
    public function overdraftPayment(CalendarImmutable $calendarDeadlineDate): float
    {
        return max($this->definedPayment($calendarDeadlineDate) - $this->totalPaid($this->paymentsByMonthlyDeadline($calendarDeadlineDate)),
            0);
    }

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return bool
     */
    public function isDeadlineReached(CalendarImmutable $calendarDeadlineDate): bool
    {
        return (new \DateTime())->getTimestamp() > $calendarDeadlineDate->deadlineTimestamp();
    }

    /**
     * @param CalendarImmutable $calendarDeadlineDate
     * @return bool
     */
    public function isDeadlinePassed(CalendarImmutable $calendarDeadlineDate): bool
    {
        if (!$this->isDeadlineReached($calendarDeadlineDate)) {
            return true;
        }

        return $this->overdraftPayment($calendarDeadlineDate) === 0.0;
    }

    /**
     * @return bool
     */
    public function isAgreementPassed(): bool
    {
        return $this->amount() === $this->totalPaid();
    }

    /**
     * @return array
     */
    public function statements(): array
    {
        $calendar = $this->term()->getCalendarScheduledDates();

        return collect($calendar)
            ->map(function (CalendarImmutable $calendarScheduledDeadline) {
                return new StatementImmutable(
                    $calendarScheduledDeadline,
                    $this->basePayment(),
                    $this->definedPayment($calendarScheduledDeadline),
                    $this->leftoverPayment($calendarScheduledDeadline),
                    !$this->isDeadlinePassed($calendarScheduledDeadline),
                    $this->term()->monthlyFee(),
                    []
                );
            })
            ->toArray();
    }

}