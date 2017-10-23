<?php

namespace App\Components\Vault\Fractional\Agreement;

use App\Components\Vault\Fractional\Agreement\Calendar\CalendarVO;
use App\Components\Vault\Fractional\Agreement\Statement\StatementVO;
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
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
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
        $key = collect($this->payments->toArray())->search(function (PaymentContract $paidPayment) use ($payment) {
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
        return collect($this->payments->toArray())->sortByDesc(function (PaymentContract $paidPayment) {
            return $paidPayment->createdAt();
        })->first();
    }

    /**
     * @param \DateTime $date
     * @return array
     */
    public function paymentsByMonthlyDeadline(\DateTime $deadlineDate): array
    {
        return collect($this->payments->toArray())
            ->sortByDesc(function (PaymentContract $paidPayment) {
                return $paidPayment->createdAt();
            })->reject(function (PaymentContract $paidPayment) use ($deadlineDate) {
                return
                    $paidPayment->createdAt() > $deadlineDate->setTime(23, 59, 59)
                    ||
                    $paidPayment->createdAt() < $deadlineDate->modify("first day of this month");
            })->toArray();
    }

    /**
     * @return float
     */
    public function totalPaid(): float
    {
        return collect($this->payments)->sum(function (PaymentContract $payment) {
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
     * @return bool
     */
    public function isDeadlineReached(): bool
    {
        // TODO: Implement isDeadlineReached() method.
    }

    /**
     * @return bool
     */
    public function isDeadlinePassed(): bool
    {
        // TODO: Implement isDeadlinePassed() method.
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
        $todayDate = new \DateTime('now');

        $totalPaid = $this->totalPaid();

        $lastPayment = $this->lastPayment();

        $monthlyPayment = floatval($this->amount() / $this->term()->months());

        return collect($this->term()->paymentCalendar())
            ->map(function (CalendarVO $calendarDate) use ($todayDate, $lastPayment, $totalPaid, $monthlyPayment) {

                $paymentsByMonth = $this->paymentsByMonthlyDeadline(new \DateTime($calendarDate->deadlineDate()));

                $scheduledPayment = (new \DateTime($calendarDate->deadlineDate()) > $lastPayment->createdAt());

                $overdue = function () use ($paymentsByMonth, $monthlyPayment) {
                    return $monthlyPayment > collect($paymentsByMonth)->sum(function (PaymentContract $paidPayment) {
                            return $paidPayment->amount();
                        });
                };

                $overdue = $overdue();

                $paidPayment = $monthlyPayment * $calendarDate->serialNumber() < $totalPaid && !$scheduledPayment;

                return new StatementVO(
                    $calendarDate,
                    $paidPayment,
                    !$scheduledPayment ? $overdue : false,
                    $monthlyPayment,
                    $scheduledPayment ? $monthlyPayment : max($monthlyPayment * $calendarDate->serialNumber() - $totalPaid,
                        0),
                    $this->amount() * $this->term()->monthlyFee(),
                    $paymentsByMonth
                );
            })
            ->toArray();
    }

}