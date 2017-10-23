<?php

namespace App\Components\Vault\Fractional\Agreement\Term;

use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\Calendar\CalendarVO;
use App\Convention\ValueObjects\Identity\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fractional_agreements_terms")
 */
class TermEntity implements TermContract
{
    /**
     * @var Identity
     * @ORM\Id
     * @ORM\Column(type="identity", unique=true)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="integer", nullable=false)
     */
    private $months;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false, name="deadline_day")
     */
    private $deadlineDay;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false, name="setup_fee")
     */
    private $setupFee;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false, name="monthly_fee")
     */
    private $monthlyFee;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false, name="created_at")
     */
    private $createdAt;

    /**
     * @var AgreementContract
     * @ORM\OneToOne(targetEntity="App\Components\Vault\Fractional\Agreement\AgreementEntity", inversedBy="term", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="agreement_id", referencedColumnName="id")
     */
    private $agreement;


    /**
     * @param Identity $id
     * @param int $months
     * @param int $deadlineDay
     * @param float $setupFee
     * @param float $monthlyFee
     * @param AgreementContract $agreement
     */
    public function __construct(Identity $id, int $months, int $deadlineDay, float $setupFee, float $monthlyFee, AgreementContract $agreement)
    {
        $this->id = $id;

        $this->createdAt = new \DateTimeImmutable();

        $this->setMonths($months);
        $this->setDeadlineDay($deadlineDay);

        $this->setupFee = $setupFee;
        $this->monthlyFee = $monthlyFee;

        $this->agreement = $agreement;

        $agreement->assignTerm($this);
    }

    /**
     * @param int $months
     * @return TermEntity
     * @throws \InvalidArgumentException
     */
    private function setMonths(int $months): TermEntity
    {
        if ($months > 0 === false) {
            throw new \InvalidArgumentException("Months can't be a zero value");
        }

        $this->months = $months;

        return $this;
    }

    /**
     * @param int $day
     * @return TermEntity
     */
    private function setDeadlineDay(int $day): TermEntity
    {
        if ($day > 0 === false) {
            throw new \InvalidArgumentException("Deadline date can't be a zero value");
        }

        if ($day > 31 === true) {
            throw new \InvalidArgumentException("Deadline date can't be greater than 31 day of month");
        }

        if ((int) $this->createdAt()->format('j') > $day) {
            throw new \InvalidArgumentException("Deadline date can't be in past. Agreement date is {$this->createdAt()->format('d M')}");
        }

        $this->deadlineDay = $day;

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
     * @return int
     */
    public function months(): int
    {
        return $this->months;
    }

    /**
     * @return int
     */
    public function deadlineDay(): int
    {
        return $this->deadlineDay;
    }

    /**
     * @return float
     */
    public function setupFee(): float
    {
        return $this->setupFee;
    }

    /**
     * @return float
     */
    public function monthlyFee(): float
    {
        return $this->monthlyFee;
    }


    /**
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return AgreementContract
     */
    public function agreement(): AgreementContract
    {
        return $this->agreement;
    }

    /**
     * @param int $months
     * @return TermContract
     */
    public function updateMonths(int $months): TermContract
    {
        $this->setMonths($months);

        return $this;
    }

    /**
     * @param int $day
     * @return TermContract
     */
    public function updateDeadlineDay(int $day): TermContract
    {
        $this->setDeadlineDay($day);

        return $this;
    }

    /**
     * @param float $setupFee
     * @return TermContract
     */
    public function updateSetupFee(float $setupFee): TermContract
    {
        $this->setupFee = $setupFee;

        return $this;
    }

    /**
     * @param float $monthlyFee
     * @return TermContract
     */
    public function updateMonthlyFee(float $monthlyFee): TermContract
    {
        $this->monthlyFee = $monthlyFee;

        return $this;
    }

    /**
     * @return array
     */
    public function paymentCalendar(): array
    {
        return collect(range(1, $this->months()))
            ->map(function(int $monthNumber) {

                $monthNumber--;

                $monthDeadlineDate = (new \DateTime($this->createdAt()->format('Y-m-d')))
                    ->modify("first day of this month")
                    ->modify("+ {$monthNumber} month")
                    ->modify("+ {$this->deadlineDay()} day")
                    ->modify("- 1 day");

                $monthNumber++;

                return new CalendarVO($monthNumber, $monthDeadlineDate);
            })
            ->toArray();
    }
}